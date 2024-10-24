<?php
namespace app\controllers\client;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Schedule;
use app\models\ScheduleOrder;
use app\models\Service;
use app\models\Company;
use app\models\Collaborator;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Flash;
use app\classes\Cart;
use app\classes\Breadcrumb;
use app\classes\MercadoPagoIntegration;
use Ramsey\Uuid\Uuid;


class ScheduleController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    private function sanitizeArgNumber($number){
        $sanitizedAgument = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
        return intval($sanitizedAgument);
    }

    public function removeToCart(array $args){
        if(count(Cart::get()) === 0){
            Cart::delete();
        }else{
            Cart::remove(intval($args[0]));
            Flash::set('resultInsertSchedule', 'Serviço removido com sucesso!','notification sucess');
            return redirect('/schedule/store');
        }
    }

    private function addToCart(int $idService,Service $serviceManager,Db $db): void{
        if(isset($idService)){
            $service = $serviceManager->getById($db,$idService);
            if($service){
                Cart::add($service);
                Flash::set('resultInsertSchedule', 'Serviço adicionado com sucesso!','notification sucess');
            }
        }
    }

    private function getAvaliableServices(Db $db,Service $serviceManager): array{
        if(count(Cart::get()) != 0){
            $servicesCompany = $serviceManager->getByCompany($db,Cart::getIdCompany());
            $availableServices = [];
            foreach ($servicesCompany as $service) {
                if(!Cart::inToCart($service)){
                    array_push($availableServices,$service);
                }
            }
            return $availableServices;
        }
        return [];
    }

    public function index(array $args){
        $db = new Db();
        $db->connect();
       

        $this->view = 'client/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            // 'schedules'=>$schedules,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get()
        ];
    }

    public function show(array $args){
        $db = new Db();
        $db->connect();
        $schedule = new Schedule();
        $schedule = $schedule->getById($db,intval($args[0]));
        $orders = new ScheduleOrder();
        $orders = $orders->getBySchedule($db,intval($args[0]));

        $this->view = 'client/showSchedule.php';
        $this->data = [
            'title'=>'Detalhes agendamento | AgendaFacil',
            'schedule'=>$schedule,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get(),
            'orders'=>$orders
        ];
    }

 

    public function store(array $args){
        $db = new Db();
        $db->connect();
        $serviceManager = new Service();
      
        if(isset($args[0])){
            $this->addToCart($this->sanitizeArgNumber($args[0]),$serviceManager,$db);
        }
        if(count(Cart::get()) === 0){
            return redirect('/');
        }

        $this->view = 'client/storeSchedule.php';
        $this->data = [
            'title'=>'Realizar agendamento | AgendaFacil',
            'navActive'=>'Agenda',
            'services'=>Cart::get(),
            'amount'=>Cart::getAmount(),
            'servicesCompany'=> $this->getAvaliableServices($db,$serviceManager),//services for modal
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'totalDuration'=>Cart::showDuration()

        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(Cart::get()){
                $db = new Db();
                $db->connect();

                $validateData = $this->validateScheduleData();
                $validateCollaborators = $this->validateCollaborators();
                $validateServices = $this->validateServices();

                if(!$validateData || !$validateCollaborators || !$validateServices){
                    Flash::set('resultInsertSchedule', 'Erro ao agendar serviço!','notification error');
                    return redirect("/schedule/store");
                }

                //TODO verificar pq nao cria sessao user com id no registro do user
                $schedule = $this->registerSchedule($db,$validateData,$_SESSION['user']->getId(),Cart::getIdCompany(),Cart::getAmount());
                $orders = $this->registerOrders($db,$schedule,Cart::get());   
            
             
                if(!$schedule || !$orders){
                    Flash::set('resultInsertSchedule', 'Erro ao agendar serviço!','message error');
                    return redirect("/schedule/store");
                }

                return redirect("/schedule");
            }
        }
    }

    
    public function getSchedules(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        if (isset($_GET['day']) && isset($_GET['month']) ) {
            // if (isset($_GET['day']) && isset($_GET['month']) && isset($_SESSION['user']) && isset($_SESSION['auth'])) {
            // returnin ['schedules'=> $schedulesDayForMonth];
            $day = intval($_GET['day']);
            $month = intval($_GET['month']);

            $date = new \DateTime();
            $date->setDate(date('Y'), $month, $day);
            $date->setTime(0, 0, 0);

            $db = new Db();
            $db->connect();

            $schedules = new Schedule();
            // $schedules = $schedules->getByClient($db,1);
            $schedules = $schedules->getByClient($db,$_SESSION['user']->getId());
            
            $schedules = array_filter($schedules, fn($schedule) => $schedule->getDateSchedule() == $date);

            header('Content-Type: application/json');
            echo json_encode($schedules);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "day" and "month" is required']);
        }
    }


    public function getAvailableTimes(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        header("Access-Control-Allow-Origin:  http://localhost:8889");
        header("Access-Control-Allow-Methods: GET, POST");


        if (isset($_GET['day']) && count(Cart::get()) != 0) {
            $db = new Db();
            $db->connect();

            $day = intval($_GET['day']);
            $amountServicesTime = $this->calculateTotalTime(Cart::get());
        
            $company = new Company;
            $company = $company->getById($db,Cart::getIdCompany());
  
            $intervalsMorning = $this->generateIntervals($company->getOpeningHoursMorningStart(), $company->getOpeningHoursMorningEnd(), $amountServicesTime);
            $intervalsAfternoon = $this->generateIntervals($company->getOpeningHoursAfternoonStart(), $company->getOpeningHoursAfternoonEnd(), $amountServicesTime);
         
            $scheduledTimes = new Schedule();
            $scheduledTimes = $scheduledTimes->getScheduledTimes($db, $day,Cart::getIdCompany());
        
            $availableTimes = ['morning'=>[],'afternoon'=>[]];
            foreach ($intervalsMorning as $interval) {
                if (!$this->isScheduled($interval, $scheduledTimes, $amountServicesTime)) {
                    array_push($availableTimes['morning'],$interval->format('H:i'));
                }
            }

            foreach ($intervalsAfternoon as $interval) {
                if (!$this->isScheduled($interval, $scheduledTimes, $amountServicesTime)) {
                    array_push($availableTimes['afternoon'],$interval->format('H:i'));
                }
            }

            header('Content-Type: application/json');
            echo json_encode($availableTimes);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "day" is required']);
        }
    }

   

    // public function isScheduled($interval, $blockedIntervals, \DateInterval $amountServicesTime) {
    //     $intervalStart = $interval;
    //     $intervalEnd = clone $intervalStart;

    //     $intervalEnd->add($amountServicesTime);
    //     foreach ($blockedIntervals as $blocked) {

    //         $blockEnd = $blocked->format('H:i');

    //         if ($intervalStart < $blockEnd && $intervalEnd > $blockStart) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    public function isScheduled($interval, $blockedIntervals, \DateInterval $amountServicesTime) {
        $intervalStart = $interval;
        $intervalEnd = clone $intervalStart;
        $intervalEnd->add($amountServicesTime);
        foreach ($blockedIntervals as $blocked) {
            $blockStart = new \DateTime($blocked['startTime']);
            $blockEnd = new \DateTime($blocked['endTime']);
            if ($intervalStart < $blockEnd && $intervalEnd > $blockStart) {
                return true;
            }
        }
        return false;
    }

    private function calculateTotalTime(array $services) {
        $totalTime = new \DateInterval('PT0H0M');
        $now = new \DateTime();
        $baseDateTime =new \DateTime($now->format('Y-m-d') . ' 00:00:00');
    
        foreach ($services as $service) {
            $duration = $service->getDuration(); // Isso é um DateTime
            
            // Calcula a diferença entre a baseDateTime e a duração
            $interval = $baseDateTime->diff($duration);
            
            // Adiciona o intervalo à totalTime
            $totalTime->h += $interval->h;
            $totalTime->i += $interval->i;
            $totalTime->s += $interval->s;
    
            // Normaliza o tempo
            if ($totalTime->s >= 60) {
                $totalTime->i += intdiv($totalTime->s, 60);
                $totalTime->s %= 60;
            }
            if ($totalTime->i >= 60) {
                $totalTime->h += intdiv($totalTime->i, 60);
                $totalTime->i %= 60;
            }
        }
    
        return $totalTime;
    }
 
    function generateIntervals(\DateTime $start, \DateTime $end, \DateInterval $interval) {
        $intervals = [];
        $current = clone $start;
        while ($current < $end) {
            // Clona o objeto $current antes de adicionar ao array
            $intervals[] = clone $current;
            $current->add($interval);
        }
        // Verifica se o último intervalo coincide exatamente com o horário de fim
        // if ($current->format('H:i') !== $end->format('H:i')) {
        //     $intervals[] = $end;
        // }
        return $intervals;
    }
    
    private function validateScheduleData(){
        $validate = new Validate();
        $validate->handle([
            'day'=>[REQUIRED,DATE],
            'time'=>[REQUIRED,TIME],
        ],'schedule');
      
        if($_POST['message']){
            $validate->handle([
                'message'=>[REQUIRED]
            ],'schedule');
        }

        if($validate->errors) {
            return false;
        }
        return $validate;
    }

    private function validateServices(){
        return Cart::get() != 0;
    }

    private function validateCollaborators(){
        if ($_POST['collaborator']) {
            foreach ($_POST['collaborator'] as $index => $collaboratorId) {
                $_SESSION['cart'][$index]->setIdCollaborator($collaboratorId);
            }
            return true;
        }
        return false;
    }
    
    private function registerSchedule($db,$validateData,$idClient,$idCompany,$amount){
        $durationServices = $this->calculateTotalTime(Cart::get());
        
        $endTime = clone $validateData->data['time'];
        $endTime->add($durationServices);

        $schedule = new Schedule($idClient,
            $idCompany,
            0,$amount,0,'',
            'obs',
            'Aguardando pagamento',
            $validateData->data['time'],
            $endTime,
            $validateData->data['day']);
           
        $schedule->insert($db);
        $schedule = $schedule->getByDataTime($db,$validateData->data['day'],$validateData->data['time'],$idCompany);
        return $schedule ? $schedule : false;
    }

    private function registerOrders(Db $db,$schedule,$services){
        $ok = true;
        $lastEndTime;

        foreach ($services as $index =>$service) {
            if ($index == 0) {
                $start = clone $schedule->getStartTime(); 
            } else {
                $start = clone $lastEndTime;
            }
    
            $interval = new \DateInterval('PT' . $service->getDuration()->format('H') . 'H' . $service->getDuration()->format('i') . 'M');
            $end = clone $start;
            $end->add($interval);
    
            $lastEndTime = $end;

            // TODO pensar se deixo id ou objeto no construtor da ordem 
            $order = new ScheduleOrder($schedule->getId(),
                                    $service->getIdCollaborator(),
                                    $service->getId(),
                                    $start,
                                    $end); 
            if(!$order->insert($db)){
                $ok = false;
            }
        }
        
       return $ok;
    }


    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        if(isset($args)){

            $db = new Db();
            $db->connect();
    
            $service = new Service();
            if($service->delete($db,intval($args[0]))){
                Flash::set('reultDeleteService', 'Erro ao excluir colaborador!','message sucess');
                return redirect("/admin/service");
            }

            Flash::set('reultDeleteService', 'Erro ao excluir colaborador!','message error');
            return redirect("/admin/service");
        }
    }
}

?>