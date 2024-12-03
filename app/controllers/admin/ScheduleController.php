<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Schedule;
use app\models\ScheduleOrder;
use app\models\Service;
use app\models\Company;
use app\models\Client;
use app\models\Collaborator;
use app\models\Images;
use app\classes\Flash;
use app\classes\Validate;
use app\classes\Breadcrumb;
use app\classes\BlockNotAdmin;
use app\classes\Cart;

class ScheduleController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

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
            return redirect('/admin/schedule/store');
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

    private function addClient(int $idClient,Client $clientManager,Db $db): void{
        if(isset($idClient)){
            if($idClient == 0){
                Cart::addClient($clientManager->getDefaultClient());
                Flash::set('resultInsertSchedule', 'Cliente adicionado com sucesso!','notification sucess');
            }else{
                $client = $clientManager->getById($db,$idClient);
                if($client){
                    Cart::addClient($client);
                    Flash::set('resultInsertSchedule', 'Cliente adicionado com sucesso!','notification sucess');
                }
            }
        }
    }

    private function getAvaliableServices(Db $db,Service $serviceManager): array{
        $servicesCompany = $serviceManager->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        $servicesCompany = $servicesCompany['services'];
        if(count(Cart::get()) != 0){
           
            $availableServices = [];
            foreach ($servicesCompany as $service) {
                if(!Cart::inToCart($service)){
                    array_push($availableServices,$service);
                }
            }
            return $availableServices;
        }
        return $servicesCompany;
    }

    public function index(array $args){
        $db = new Db();
        $db->connect();
        $schedules = new Schedule();

        $currentPage = 1;
        $recordsPerPage = 10;

        if(isset($args[0])){
            $currentPage = intval($args[0]);
        }
     

        $startDate = isset($_GET['startDate']) ? intval($_GET['startDate']) : '';
        $endDate = isset($_GET['endDate']) ? intval($_GET['endDate']) : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';

      
    
        if (!isset($_GET['startDate']) && !isset($_GET['endDate']) && !isset($_GET['status'])) {
            $result = $schedules->getByCompanyPaginate($db, $_SESSION['collaborator']->getIdCompany(), $currentPage, $recordsPerPage);
        } else {
            $result = $schedules->getSchedulesByFilters(
                $db,
                $_SESSION['collaborator']->getIdCompany(),
                $status,
                $startDate,
                $endDate,
                $currentPage,
                $recordsPerPage
            );
        }
    
        $pagination = $result['pagination'];
        $schedules = $result['schedules'];



        $this->view = 'admin/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'agenda',
            'schedules'=>$schedules,
            'pagination'=>$pagination
        ];
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

            $client = new Client();
            $schedules = new Schedule();
            $schedules = $schedules->getByCompanyForDate($db,$_SESSION['collaborator']->getIdCompany(),$startDate,$endDate);
            
            $arrayFormatedSchedules = [];

            foreach ($schedules as $schedule) {
                if($schedule->getStatus() != 'cancelado'){
                    array_push($arrayFormatedSchedules, [
                        'id' => $schedule->getId(),
                        'title' => ' - '.$client->getById($db,$schedule->getIdClient())->getName(),
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

    public function searchClient(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        if (isset($_GET['query'])) {
            $query = $_GET['query'];
            $searchTerm = "%" . $query . "%";

            $db = new Db();
            $db->connect();

            $db->setTable("client");
            $clients = $db->query("name, phone , idClient, avatar","name LIKE '$searchTerm' OR phone LIKE '$searchTerm'");

            header('Content-Type: application/json');
            echo json_encode($clients);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "query" is required']);
        }
    }

    public function edit(array $args){
        BlockNotAdmin::block($this,['edit']);
        if(isset($args)){
            $db = new Db();
            $db->connect();
    
            $service = new Service();
            $service = $service->getById($db,intval($args[0]));
        }

        $this->view = 'admin/registerAndUploadService.php';
        $this->data = [
            'title'=>'Editar serviço | AgendaFacil',
            'id'=>intval($args[0]),
            'navActive'=>'servicos',
            'legend'=>'Editar serviço',
            'action'=>'/admin/service/update',
            'service'=>$service,
        ];

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


        if (isset($_GET['date'])) {
            $db = new Db();
            $db->connect();

            $company = new Company;
            $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());
         
            $date =  new \DateTime($_GET['date']);
            $amountServicesTime = $this->calculateTotalTime(Cart::get());

            $dayOfWeek = $date->format('w');
            $hoursOfDay = $company->getHourByDay($dayOfWeek);

           
            if($hoursOfDay){
                $intervalsMorning = $this->generateIntervals($hoursOfDay->getOpeningHoursMorningStart(), $hoursOfDay->getOpeningHoursMorningEnd(), $amountServicesTime);
                $intervalsAfternoon = $this->generateIntervals($hoursOfDay->getOpeningHoursAfternoonStart(), $hoursOfDay->getOpeningHoursAfternoonEnd(), $amountServicesTime);
             
                $scheduledTimes = new Schedule();
                $scheduledTimes = $scheduledTimes->getScheduledTimes($db, $date->format('Y-m-d'),$_SESSION['collaborator']->getIdCompany());
            
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

    public function show(array $args){
        if(isset($args)){
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

            $actionCancel = '/admin/schedule/cancel';
            $actionComplete = '/admin/schedule/complete';
            $linkBack = '/admin/schedule';

        }

        $this->view = 'client/showSchedule.php';
        $this->data = [
            'title'=>'Visualizar agendamento | AgendaFacil',
            'schedule'=>$schedule,
            'orders'=>$orders,
            'reasons'=>$arrayReason,
            'actionCancel'=>$actionCancel,
            'actionComplete'=>$actionComplete,
            'linkBack'=>$linkBack

        ];
    }

    public function update(array $args){

    }

   
    //TODO finalizar agendamento via admin
    //TODO finalizar visualizacao da agenda - admin - cliente - colaborador
    //TODO verificar problema dos inputs time para exibir tempo do db
    public function store(array $args){
        // BlockNotAdmin::block($this,['store']);
        $db = new Db();
        $db->connect();
        $serviceManager = new Service();
        $clientManager = new Client();
     
        if(isset($args[0]) && $args[0] == 'client' && $args[1] == 'default'){
            $this->addClient(0,$clientManager,$db);
        }

        if(isset($args[0]) && $args[0] == 'client'){
            $this->addClient($this->sanitizeArgNumber($args[1]),$clientManager,$db);
        }

        if(isset($args[0]) && $args[0] == 'client' && $args[1] == 'remove'){
            Cart::removeClient();
            Flash::set('resultInsertSchedule', 'Cliente removido com sucesso!','notification sucess');
            redirect('/admin/schedule/store');
        }

        if(isset($args[0])){
            $this->addToCart($this->sanitizeArgNumber($args[0]),$serviceManager,$db);
        }

        $this->view = 'admin/registerSchedule.php';
        $this->data = [
            'title'=>'Realizar agendamento | AgendaFacil',
            'navActive'=>'Agenda',
            'legend'=>'Agendar serviço',
            'action'=>'/admin/schedule/store',
            'services'=>Cart::get(),
            'amount'=>Cart::getAmount(),
            'servicesCompany'=> $this->getAvaliableServices($db,$serviceManager),
            'totalDuration'=>Cart::showDuration(),
            'client'=> isset($_SESSION['clientSelected']) ? $_SESSION['clientSelected'] : null 
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(Cart::get()){
                $db = new Db();
                $db->connect();

                $validateData = $this->validateScheduleData();
                $validateCollaborators = $this->validateCollaborators();
                $validateServices = $this->validateServices();

                if(!$validateData || !$validateCollaborators || !$validateServices){
                    Flash::set('resultInsertSchedule', 'Erro 399 ao agendar serviço!','notification error');
                    return redirect("/admin/schedule/store");
                }

                $schedule = $this->registerSchedule($db,$validateData,Cart::getClient()->getId(),Cart::getIdCompany(),Cart::getAmount());
                $orders = $this->registerOrders($db,$schedule,Cart::get());   
            
             
                if(!$schedule || !$orders){
                    Flash::set('resultInsertSchedule', 'Erro 408 ao agendar serviço!','notification error');
                    return redirect("/admin/schedule/store");
                }

                Cart::delete();
                Cart::removeClient();

                //TODO enviar email para agendamento
                Flash::set('resultInsertSchedule', 'Erro ao agendar serviço!','notification sucess');
                return redirect("/admin/schedule");
            }
        }
    }

    private function validateScheduleData(){
        $validate = new Validate();
        $validate->handle([
            'date'=>[REQUIRED,DATE],
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
                                $validateData->data['date'],
                                new \DateTime(),
                                '');
           
        if($schedule->insert($db)){
            $schedule = $schedule->getByDataTime($db,$validateData->data['date'],$validateData->data['time'],$idCompany);
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
                
          
            if(!$order->insert($db)){
                $ok = false;
            }
        }

       return $ok;
    }

    private function getCollaboratorsByServices(Db $db,array $idsServices,$idCompany){
        $collaborators = [];
        $collaboratorManager = new Collaborator();
        foreach ($idsServices as $id) {
            $collaborator = $collaboratorManager->getById($db,$id,$idCompany);
            array_push($collaborators,$collaborator);
        }
        return $collaborators;
    }

    private function getMonthDays(){
        $today = new \DateTime();
        $fisrtDay = new \DateTime($today->format('Y-m-01'));
        $daysOfMonth = [];
        while ($fisrtDay->format('m') == $today->format('m')) {
            $daysOfMonth[] = $fisrtDay->format('Y-m-j'); // 'j' para o dia do mês sem zeros à esquerda
            $fisrtDay->modify('+1 day');
        }
        return $daysOfMonth;
    }


    public function cancel(array $args){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $validate = new Validate();
            if($_POST['idSchedule']){
                $validate->handle([
                    'reason'=>[REQUIRED]
                ],'schedule');

                $id = intval($_POST['idSchedule']);

                if($validate->errors) {
                    Flash::set('resultUpdateSchedule', 'Erro ao cancelar agendamento!','message error');
                    return redirect("/admin/schedule");
                }
    
                $db = new Db();
                $db->connect();
                $schedule = new Schedule();
                $schedule = $schedule->getById($db,$id);
                $schedule->setStatus('cancelado');
                $schedule->setCancellationReason($validate->data['reason']);
                $schedule->setCancellationDescription($_POST['message']);
                
                if($schedule->update($db,$id)){
                    Flash::set('resultUpdateSchedule', 'Erro ao cancelar agendamento!','notification error');
                    return redirect("/admin/schedule");
                }
            }
    
         
        }
    }

    public function complete(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if($_POST['idSchedule']){
                $id = intval($_POST['idSchedule']);
                
                $db = new Db();
                $db->connect();
                $schedule = new Schedule();
                $schedule = $schedule->getById($db,$id);
                $schedule->setStatus('concluido');
                
                if($schedule->update($db,$id)){
                    Flash::set('resultUpdateSchedule', 'Erro ao concluir agendamento!','notification error');
                    return redirect("/admin/schedule");
                }
            }
    
        }
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