<?php
namespace app\controllers\client;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Schedule;
use app\models\ScheduleOrder;
use app\models\Service;
use app\models\Receipt;
use app\models\Company;
use app\models\Collaborator;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Flash;
use app\classes\Cart;
use app\classes\Breadcrumb;
use app\controllers\admin\NotificationController;

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
            $servicesCompany = $servicesCompany['services'];
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
        $arrayReason = [['label'=>'Mudança de data/hora solicitada','value'=>'mudança de data/hora solicitada'],
                        ['label'=>'Imprevisto do cliente','value'=>'imprevisto do cliente'],
                        ['label'=>'Imprevisto do prestador de serviço','value'=>'imprevisto do prestador de serviço'],
                        ['label'=>'Outro','value'=>'outro']];
        $action = '/schedule/cancel';
        $linkBack = '/schedule';
        

        $this->view = 'client/showSchedule.php';
        $this->data = [
            'title'=>'Detalhes agendamento | AgendaFacil',
            'schedule'=>$schedule,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get(),
            'orders'=>$orders,
            'reasons'=>$arrayReason,
            'action'=>$action,
            'linkBack'=>$linkBack

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

                Cart::delete();
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

        if (isset($_GET['start']) && isset($_GET['end']) ) {
            $startDate = new \DateTime($_GET['start']);
            $endDate = new \DateTime($_GET['end']);

            $db = new Db();
            $db->connect();

            $company = new Company();
            $schedules = new Schedule();
            $schedules = $schedules->getByClient($db,$_SESSION['user']->getId());
            // $schedules = new Schedule();
            // $schedules = $schedules->getByCompanyForDate($db,Cart,$startDate,$endDate);
            
            $arrayFormatedSchedules = [];

            foreach ($schedules as $schedule) {
                if($schedule->getStatus() != 'cancelado'){
                    array_push($arrayFormatedSchedules, [
                        'id' => $schedule->getId(),
                        'title' => ' - '.$company->getById($db,$schedule->getIdCompany())->getName(),
                        'start' => (new \DateTime($schedule->getDateSchedule()->format('Y-m-d') . ' ' . $schedule->getStartTime()->format('H:i:s')))->format('Y-m-d H:i:s'),
                        'end' => (new \DateTime($schedule->getDateSchedule()->format('Y-m-d') . ' ' . $schedule->getEndTime()->format('H:i:s')))->format('Y-m-d H:i:s')
                    ]);
                }
            }

           

            header('Content-Type: application/json');
            echo json_encode($arrayFormatedSchedules);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "start" and "end" is required']);
        }
    }
  
    // public function getSchedules(){
    //     //evita erros com o mvc
    //     $this->master = 'masterapi.php';
    //     $this->view = 'api.php';
    //     $this->data = [
    //         'title'=>'api',
    //     ];

    //     if (isset($_GET['day']) && isset($_GET['month']) ) {

    //         $day = intval($_GET['day']);
    //         $month = intval($_GET['month']);

    //         $date = new \DateTime();
    //         $date->setDate(date('Y'), $month, $day);
    //         $date->setTime(0, 0, 0);

    //         $db = new Db();
    //         $db->connect();

    //         $schedules = new Schedule();
    //         // $schedules = $schedules->getByClient($db,1);
    //         $schedules = $schedules->getByClient($db,$_SESSION['user']->getId());
            
    //         $schedules = array_filter($schedules, fn($schedule) => $schedule->getDateSchedule() == $date);

    //         header('Content-Type: application/json');
    //         echo json_encode($schedules);
    //         exit();
    //     }else {
    //         header('HTTP/1.1 400 Bad Request');
    //         echo json_encode(['error' => 'Parameter "day" and "month" is required']);
    //     }
    // }


    public function getAvailableTimes(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        header("Access-Control-Allow-Origin:  http://localhost:8889");
        header("Access-Control-Allow-Methods: GET, POST");


        if (isset($_GET['date']) && count(Cart::get()) != 0) {
            $db = new Db();
            $db->connect();

            $company = new Company;
            $company = $company->getById($db,Cart::getIdCompany());

            $date =  new \DateTime($_GET['date']);
            $amountServicesTime = $this->calculateTotalTime(Cart::get());

            $dayOfWeek = $date->format('w');
          
            $hoursOfDay = $company->getHourByDay($dayOfWeek);
           
            if($hoursOfDay){
                $intervalsMorning = $this->generateIntervals($hoursOfDay->getOpeningHoursMorningStart(), $hoursOfDay->getOpeningHoursMorningEnd(), $amountServicesTime);
                $intervalsAfternoon = $this->generateIntervals($hoursOfDay->getOpeningHoursAfternoonStart(), $hoursOfDay->getOpeningHoursAfternoonEnd(), $amountServicesTime);
             
                $scheduledTimes = new Schedule();
                $scheduledTimes = $scheduledTimes->getScheduledTimes($db, $date->format('Y-m-d'),Cart::getIdCompany());
            
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
                header('Content-Type: application/json');
                echo json_encode(['morning'=>[],'afternoon'=>[]]);
                exit();
            }
            
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "day" is required']);
        }
    }

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
            $intervals[] = clone $current;
            $current->add($interval);
        }
        return $intervals;
    }
    
    private function validateScheduleData(){
        $validate = new Validate();
        $validate->handle([
            'inputDate'=>[REQUIRED,DATE],
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
                                0,
                                $amount,
                                0,
                                '',
                                isset($validateData->data['message']) ? $validateData->data['message'] : '',
                                'Confirmado',
                                $validateData->data['time'],
                                $endTime,
                                $validateData->data['inputDate'],
                                new \DateTime(),
                                '');
           
        if($schedule->insert($db)){
            $schedule = $schedule->getByDataTime($db,$validateData->data['inputDate'],$validateData->data['time'],$idCompany);
            NotificationController::store(0,"Novo agendamento recebido!","/admin/schedule/show/".$schedule->getId(),new \DateTime(),Cart::getIdCompany(),0);//notification compay
            return $schedule ? $schedule : false;
        }
        return false;
        
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

            $order = new ScheduleOrder($schedule->getId(),
                                    $service->getIdCollaborator(),
                                    $service->getId(),
                                    $start,
                                    $end); 
                
            $paymentCollaborators = $this->registerPaymentsCollaborators($db,$service->getIdCollaborator(),$service->getId(),$schedule->getIdCompany());
            $receiptCompany = $this->registerReceipt($db,floatval($schedule->getTotalPaid()),$schedule->getIdCompany());
          
            if(!$order->insert($db) || !$paymentCollaborators || !$receiptCompany){
                $ok = false;
            }
        }

        NotificationController::store(0,"Novo agendamento recebido!","/admin/schedule/show/".$schedule->getId(),new \DateTime(),0,$service->getIdCollaborator());//notification compay
       return $ok;
    }

    private function registerReceipt(Db $db, float $amount, int $idCompany){
        $receipt = new Receipt(floatval($amount),0,$idCompany);
        if(!$receipt->insert($db)){
            return false;
        }

        return true;
    }

    private function registerPaymentsCollaborators(Db $db,int $idCollaborator, int $idService,int $idCompany){
        $service = new Service();
        $service = $service->getById($db,$idService);
        $collaborator = new Collaborator();
        $collaborator = $collaborator->getById($db,$idCollaborator);

        $amountCollaborator = $service->getPrice() * $collaborator->getCommission();
        $receipt = new Receipt(floatval($amountCollaborator),$idCollaborator,$idCompany);
        if(!$receipt->insert($db)){
            return false;
        }

        return true;
    }

    public function evaluateSchedule(array $args){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();
            $evaluation = new Evaluation();
            

        }
    }

    public function cancel(array $args){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $validate = new Validate();
            if($_POST['message'] && $_POST['id']){
                $validate->handle([
                    'message'=>[REQUIRED],
                    'reason'=>[REQUIRED]
                ],'schedule');

                $id = intval($_POST['id']);
            }
    
            if($validate->errors) {
                Flash::set('resultUpdateSchedule', 'Erro ao cancelar agendamento!','message error');
                return redirect("/schedule");
            }

            $db = new Db();
            $db->connect();
            $schedule = new Schedule();
            $schedule = $schedule->getById($db,$id);
            $schedule->setStatus('cancelado');
            $schedule->setCancellationReason($validate->data['reason']);
            $schedule->setCancellationDescription($validate->data['message']);
            
            if($schedule->update($db,$id)){
                Flash::set('resultUpdateSchedule', 'Erro ao cancelar agendamento!','message error');
                return redirect("/schedule");
            }
        }
    }


    public function destroy(array $args){
     
    }
}

?>