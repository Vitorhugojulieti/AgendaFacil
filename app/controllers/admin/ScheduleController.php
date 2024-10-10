<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Schedule;
use app\models\Service;
use app\models\Company;
use app\models\Collaborator;
use app\models\Images;
use app\classes\Flash;
use app\classes\Validate;
use app\classes\Breadcrumb;
use app\classes\BlockNotAdmin;

class ScheduleController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    public function index(array $args){
        $db = new Db();
        $db->connect();

        $schedules = new Schedule();
        $schedules = $schedules->getByCompany($db,$_SESSION['collaborator']->getIdCompany());

        $this->view = 'admin/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            // 'schedules'=>$schedules,
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'agenda',
            'schedules'=>$schedules
        ];
    }

    public function filter(array $args){
        
    }

    public function canceled(){
        verifySession();

        $db = new Db();
        $db->connect();

        $schedules = new Schedule();
        $schedules = $schedules->getByCompanyByStatus($db,$_SESSION['collaborator']->getIdCompany(),'cancelado');

        $this->view = 'admin/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            // 'schedules'=>$schedules,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'agenda',
            'schedules'=>$schedules
        ];
    }

    public function confirmado(){

        $db = new Db();
        $db->connect();

        $schedules = new Schedule();
        $schedules = $schedules->getByCompanyByStatus($db,$_SESSION['collaborator']->getIdCompany(),'confirmado');

        $this->view = 'admin/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            // 'schedules'=>$schedules,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'agenda',
            'schedules'=>$schedules
        ];
    }
//TODO trocar nomes para ingles
    public function aguardando(){
        verifySession();

        $db = new Db();
        $db->connect();

        $schedules = new Schedule();
        $schedules = $schedules->getByCompanyByStatus($db,$_SESSION['collaborator']->getIdCompany(),'Aguardando pagamento');

        $this->view = 'admin/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            // 'schedules'=>$schedules,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'agenda',
            'schedules'=>$schedules
        ];
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

    public function show(array $args){
        if(isset($args)){
            $db = new Db();
            $db->connect();
    
            // $service = new Service();
            // $service = $service->getById($db,intval($args[0]));
        }

        $this->view = 'admin/showSchedule.php';
        $this->data = [
            'title'=>'Visualizar agendamento | AgendaFacil',
            // 'service'=>$service,
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

        $services = new Service();
        $services = $services->getAll($db);
        $collaborators = new Collaborator();
        $collaborators = $collaborators->getAll($db);

        // $hours = $this->getAvailableTimes($db,$args,1);
        $this->view = 'admin/registerSchedule.php';
        $this->data = [
            'title'=>'Realizar agendamento | AgendaFacil',
            'navActive'=>'Agenda',
            'legend'=>'Agendar serviço',
            'action'=>'/admin/schedule/store',
            'services'=>$services,
            'collaborators'=>$collaborators,
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
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

    private function getAvailableTimes(Db $db,array $idsServices,$idCompany,$day){
        $amountServicesTime = $this->calculateTotalTime($db,$idsServices);
        $intervalString = "PT{$amountServicesTime->i}M";
        $amountServicesTime = new \DateInterval($intervalString);
        //pegar id da empresa
        $company = new Company;
        $company = $company->getById($db,$idCompany);
        //pegar horarios
        $start = new \DateTime($company->getOpeningHoursStart());
        $end = new \DateTime($company->getOpeningHoursEnd());
        //gerar intervalos possiveis
        $intervals = $this->generateIntervals($start,$end,$amountServicesTime);
        //pegar horarios agendados
        $scheduledTimes = new Schedule();
        $scheduledTimes  = $scheduledTimes->getScheduledTimes($db,2);
        var_dump($scheduledTimes);
        die();
        //criar novo array somente com horarios disponiveis
        $availableTimes = [];
        foreach ($intervals as $interval) {
            if(!$this->isScheduled($interval,$scheduledTimes,$amountServicesTime)){
                $availableTimes[] = $interval;
            }
        }
        return $availableTimes;
    }

    private function getAvailableDate(Db $db,array $idsServices,$idCompany){
        $amountServicesTime = $this->calculateTotalTime($db,$idsServices);
        $intervalString = "PT{$amountServicesTime->i}M";
        $amountServicesTime = new \DateInterval($intervalString);
        //pegar id da empresa
        $company = new Company;
        $company = $company->getById($db,$idCompany);
        //pegar horarios
        $start = new \DateTime($company->getOpeningHoursStart());
        $end = new \DateTime($company->getOpeningHoursEnd());
        //gerar intervalos possiveis
        $intervals = $this->generateIntervals($start,$end,$amountServicesTime);
        //pegar horarios agendados
        $schedule = new Schedule();
        $avaliableDays =[];
       // –pegar um array somente com os dias que restam do mês a partir do atual —-
       $monthDays = $this->getMonthDays();
       foreach($monthDays as $day){
            $scheduledTimes = $schedule->getScheduledTimes($db,$day);
            //criar novo array somente com horarios disponiveis
            $availableTimes = [];
            foreach ($intervals as $interval) {
                if(!$this->isScheduled($interval,$scheduledTimes,$amountServicesTime)){
                    array_push($availableTimes,$interval);
                }
            }
            Array_push($avaliableDays,["day"=>$day,"times"=>$availableTimes]);
        }
        //retornar se dias com horários disponiveis
        return $avaliableDays;
    }

    public function isScheduled($interval, $blockedIntervals, \DateInterval $amountServicesTime) {
        $intervalStart = new \DateTime($interval);
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

    private function calculateTotalTime(Db $db,array $idsServices){
        $amountServicesTime = new \DateInterval('PT0H0M');
        $service = new Service();

        for ($i=0; $i < count($idsServices); $i++) { 
            $serviceObj = $service->getById($db,intval($idsServices[$i]));
            list($h, $m) = explode(':', $serviceObj->getDuration());
            $amountServicesTime->h += $h;
            $amountServicesTime->i += $m;

            if ($amountServicesTime->i >= 60) {
                $amountServicesTime->h += floor($amountServicesTime->i / 60);
                $amountServicesTime->i = $amountServicesTime->i % 60;
            }
        }
        return $amountServicesTime;
    }

    function generateIntervals(\DateTime $start, \DateTime $end, \DateInterval $interval) {
        $intervals = [];
    
        // Adicionar o tempo de intervalo como string
        $current = clone $start;
    
        while ($current < $end) {
            $intervals[] = $current->format('H:i');
    
            // Adicionar o intervalo de tempo
            $current->add($interval);
        }
    
        // Adicionar o horário final se não estiver incluído
        if ($current->format('H:i') !== $end->format('H:i')) {
            $intervals[] = $end->format('H:i');
        }
    
        return $intervals;
    }
    
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
        $imagesRegister = new Images();
        $dataImages = [
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image1']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image2']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image3']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
        ];

        return $imagesRegister->insert($db,$dataImages);
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