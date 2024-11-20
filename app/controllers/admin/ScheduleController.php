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
        $schedules = $schedules->getByCompany($db,$_SESSION['collaborator']->getIdCompany());

        $company = new Company();
        $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());
        $activeCompany = $company->getRegistrationComplete() == 1 ? 'Empresa ativa' : 'Empresa inativa'; 

        $this->view = 'admin/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            // 'schedules'=>$schedules,
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'agenda',
            'schedules'=>$schedules,
            'activeCompany'=>$company->getRegistrationComplete() == 1 ? 'Empresa ativa' : 'Empresa inativa'

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

            $action = '/admin/schedule/cancel';
            $linkBack = '/admin/schedule';

        }

        $this->view = 'client/showSchedule.php';
        $this->data = [
            'title'=>'Visualizar agendamento | AgendaFacil',
            'schedule'=>$schedule,
            'orders'=>$orders,
            'reasons'=>$arrayReason,
            'action'=>$action,
            'linkBack'=>$linkBack

        ];
    }

    public function update(array $args){
        BlockNotAdmin::block($this,['update']);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();

            $validate = new Validate();
            $service = new Service();
            $service = $service->getById($db,intval($_POST['id']));

            if($_FILES['image1'] && $_FILES['image1']['error'] == 0){
                $validate->handle(['image1'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image1']['success'] ? $validate->data['image1']['link'] : AVATAR_DEFAULT);
            }

            if($_FILES['image2'] && $_FILES['image2']['error'] == 0){
                $validate->handle(['image2'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image2']['success'] ? $validate->data['image2']['link'] : AVATAR_DEFAULT);
            }

            if($_FILES['image3'] && $_FILES['image3']['error'] == 0){
                $validate->handle(['image3'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image3']['success'] ? $validate->data['image3']['link'] : AVATAR_DEFAULT);
            }

            if($_POST['name'] && $service->getName() !== $_POST['name']){
                $validate->handle(['name'=>[REQUIRED]],'service');
                $service->setName($validate->data['name']);
            }

            if($_POST['description'] && $service->getDescription() !== $_POST['description']){
                $validate->handle(['description'=>[REQUIRED]],'service');
                $service->setDescription($validate->data['description']);
            }

            if($_POST['duration'] && $service->getDuration() !== $_POST['duration']){
                $validate->handle(['duration'=>[REQUIRED]],'service');
                $service->setDuration($validate->data['duration']);
            }

            if($_POST['price'] && $service->getPrice() !== $_POST['price']){
                $validate->handle(['price'=>[REQUIRED]],'service');
                $service->setPrice($validate->data['price']);
            }

            if($validate->errors) {
                return redirect('/admin/collaborator/edit');
            }
            
            if($service->update($db,$service->getId())){
                Flash::set('resultUpdateService', 'Serviço atualizado com sucesso!','message sucess');
                return redirect("/admin/service");
            }

            Flash::set('resultUpdateService', 'Erro ao editar serviço!','message error');
            return redirect("/admin/service/edit");
        }
    }

   

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
        }

        if(isset($args[0])){
            $this->addToCart($this->sanitizeArgNumber($args[0]),$serviceManager,$db);
        }

        // $hours = $this->getAvailableTimes($db,$args,1);
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
            var_dump($_POST);
            die();
            $db = new Db();
            $db->connect();

            $validateData = $this->validateScheduleData();
            $validateCollaborators = $this->validateCollaborators();
            $validateServices = $this->validateServices();

            if(!$validateData || !$validateCollaborators || !$validateServices){
                return redirect("/admin/schedule/store");
            }

            $schedule = $this->registerSchedule($db,$validateData,$_SESSION['collaborator']->getIdCompany());
            $services = $this->registerServices($db,$service,$_SESSION['collaborator']->getIdCompany(),$validateImages);   
            $collaborators = $this->registerCollaborators($db,$service,$_SESSION['collaborator']->getIdCompany(),$validateImages);   

            if(!$schedule || !$services || $collaborators){
                Flash::set('resultInsertSchedule', 'Erro ao agendar serviço!','message error');
                return redirect("/admin/schedule/store");
            }

            NotificationController::store();//notification compay
            NotificationController::store();//notification collaborator
            Flash::set('resultInsertSchedule', 'Serviço agendado com sucesso!','message sucess');
            return redirect("/admin/schedule");
        }
    }

    private function validateScheduleData(){
        $validate = new Validate();
        $validate->handle([
            'name'=>[REQUIRED],
            'description'=>[REQUIRED],
            'price'=>[REQUIRED],
            'duration'=>[TIME],
        ],'services');
        if($validate->errors) {
            return false;
        }

        return $validate;
    }

    private function validateCollaborators(){
        $validateImages = new Validate();
        $validateImages->handle([
            'image1'=>[IMAGE],
            'image2'=>[IMAGE],
            'image3'=>[IMAGE],
        ],'services');

        if($validateImages->errors) {
            return false;
        }
        return $validateImages;
    }

    private function validateServices(){
        $validateImages = new Validate();
        $validateImages->handle([
            'image1'=>[IMAGE],
            'image2'=>[IMAGE],
            'image3'=>[IMAGE],
        ],'services');

        if($validateImages->errors) {
            return false;
        }
        return $validateImages;
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

    // private function getAvailableTimes(Db $db,array $idsServices,$idCompany,$day){
    //     $amountServicesTime = $this->calculateTotalTime($db,$idsServices);
    //     $intervalString = "PT{$amountServicesTime->i}M";
    //     $amountServicesTime = new \DateInterval($intervalString);
    //     //pegar id da empresa
    //     $company = new Company;
    //     $company = $company->getById($db,$idCompany);
    //     //pegar horarios
    //     $start = new \DateTime($company->getOpeningHoursStart());
    //     $end = new \DateTime($company->getOpeningHoursEnd());
    //     //gerar intervalos possiveis
    //     $intervals = $this->generateIntervals($start,$end,$amountServicesTime);
    //     //pegar horarios agendados
    //     $scheduledTimes = new Schedule();
    //     $scheduledTimes  = $scheduledTimes->getScheduledTimes($db,2);
    //     var_dump($scheduledTimes);
    //     die();
    //     //criar novo array somente com horarios disponiveis
    //     $availableTimes = [];
    //     foreach ($intervals as $interval) {
    //         if(!$this->isScheduled($interval,$scheduledTimes,$amountServicesTime)){
    //             $availableTimes[] = $interval;
    //         }
    //     }
    //     return $availableTimes;
    // }

    // private function getAvailableDate(Db $db,array $idsServices,$idCompany){
    //     $amountServicesTime = $this->calculateTotalTime($db,$idsServices);
    //     $intervalString = "PT{$amountServicesTime->i}M";
    //     $amountServicesTime = new \DateInterval($intervalString);
    //     //pegar id da empresa
    //     $company = new Company;
    //     $company = $company->getById($db,$idCompany);
    //     //pegar horarios
    //     $start = new \DateTime($company->getOpeningHoursStart());
    //     $end = new \DateTime($company->getOpeningHoursEnd());
    //     //gerar intervalos possiveis
    //     $intervals = $this->generateIntervals($start,$end,$amountServicesTime);
    //     //pegar horarios agendados
    //     $schedule = new Schedule();
    //     $avaliableDays =[];
    //    // –pegar um array somente com os dias que restam do mês a partir do atual —-
    //    $monthDays = $this->getMonthDays();
    //    foreach($monthDays as $day){
    //         $scheduledTimes = $schedule->getScheduledTimes($db,$day);
    //         //criar novo array somente com horarios disponiveis
    //         $availableTimes = [];
    //         foreach ($intervals as $interval) {
    //             if(!$this->isScheduled($interval,$scheduledTimes,$amountServicesTime)){
    //                 array_push($availableTimes,$interval);
    //             }
    //         }
    //         Array_push($avaliableDays,["day"=>$day,"times"=>$availableTimes]);
    //     }
    //     //retornar se dias com horários disponiveis
    //     return $avaliableDays;
    // }

    // public function isScheduled($interval, $blockedIntervals, \DateInterval $amountServicesTime) {
    //     $intervalStart = new \DateTime($interval);
    //     $intervalEnd = clone $intervalStart;
    //     $intervalEnd->add($amountServicesTime);
    //     foreach ($blockedIntervals as $blocked) {
    //         $blockStart = new \DateTime($blocked['startTime']);
    //         $blockEnd = new \DateTime($blocked['endTime']);
    //         if ($intervalStart < $blockEnd && $intervalEnd > $blockStart) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    // private function calculateTotalTime(Db $db,array $idsServices){
    //     $amountServicesTime = new \DateInterval('PT0H0M');
    //     $service = new Service();

    //     for ($i=0; $i < count($idsServices); $i++) { 
    //         $serviceObj = $service->getById($db,intval($idsServices[$i]));
    //         list($h, $m) = explode(':', $serviceObj->getDuration());
    //         $amountServicesTime->h += $h;
    //         $amountServicesTime->i += $m;

    //         if ($amountServicesTime->i >= 60) {
    //             $amountServicesTime->h += floor($amountServicesTime->i / 60);
    //             $amountServicesTime->i = $amountServicesTime->i % 60;
    //         }
    //     }
    //     return $amountServicesTime;
    // }

    // function generateIntervals(\DateTime $start, \DateTime $end, \DateInterval $interval) {
    //     $intervals = [];
    
    //     // Adicionar o tempo de intervalo como string
    //     $current = clone $start;
    
    //     while ($current < $end) {
    //         $intervals[] = $current->format('H:i');
    
    //         // Adicionar o intervalo de tempo
    //         $current->add($interval);
    //     }
    
    //     // Adicionar o horário final se não estiver incluído
    //     if ($current->format('H:i') !== $end->format('H:i')) {
    //         $intervals[] = $end->format('H:i');
    //     }
    
    //     return $intervals;
    // }
    
    private function registerSchedule($db,$idService,$idCompany,$validateImages){
        $imagesRegister = new Images();
        $dataImages = [
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image1']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image2']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image3']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
        ];

        return $imagesRegister->insert($db,$dataImages);
    }

    private function registerServices(Db $db,$validate,$idCompany){
        $service = new Service(
            $validate->data['name'],
            $validate->data['description'],
            $validate->data['price'],
            (float)$validate->data['duration'],
            true,$idCompany);

        $service->insert($db);
        $service = $service->getIdByName($db,$validate->data['name'],$idCompany);
        return $service ? $service : false;
    }

    private function registerCollaborators($db,$idService,$idCompany,$validateImages){
      
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
                return redirect("/admin/schedule");
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
                return redirect("/admin/schedule");
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