<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Collaborator;
use app\models\Company;
use app\models\Service;
use app\models\Schedule;
use app\classes\Flash;
use app\classes\Old;
use app\classes\ContactEmail;
use app\classes\ImageUpload;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Breadcrumb;
use Faker\Factory;



class CollaboratorController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    private function sanitizeArgNumber($arg){
        $sanitizedAgument = filter_var($arg, FILTER_SANITIZE_NUMBER_INT);
        return filter_var($sanitizedAgument, FILTER_VALIDATE_INT) ? $sanitizedAgument : false;
    }

    public function index(array $args){
        BlockNotAdmin::block($this,['index']);

        $db = new Db();
        $db->connect();
        $collaborators = new Collaborator();
        $currentPage = 1;
        $recordsPerPage = 10;

        if(isset($args[0])){
            $currentPage = intval($args[0]);
        }
    
       
        if (!isset($_GET['nivel']) && !isset($_GET['status'])) {
            $result = $collaborators->getByCompany($db,$_SESSION['collaborator']->getIdCompany(), $currentPage, $recordsPerPage);
        } else {

            $status = isset($_GET['status']) ? $_GET['status'] : "";
            $nivel = isset($_GET['nivel']) ? $_GET['nivel'] : "";
    
            $result = $collaborators->getCollaboratorsByFilters(
                $db,
                $_SESSION['collaborator']->getIdCompany(),
                $status,
                $nivel,
                $currentPage,
                $recordsPerPage
            );
        }

        $pagination = $result['pagination'];
        $collaborators = $result['collaborators'];

        usort($collaborators, function($a, $b) {
            return $b->getActive() - $a->getActive();
        });

        $this->view = 'admin/collaborators.php';
        $this->data = [
            'title'=>'Colaboradores | AgendaFacil',
            'collaborators'=>$collaborators,
            'navActive'=>'colaboradores',
            'pagination'=>$pagination,
        ];
    }

    public function edit(array $args){
        BlockNotAdmin::block($this,['edit']);

        $idCollaborator = $this->sanitizeArgNumber($args[0]);
        if(isset($args) && $idCollaborator){
            $db = new Db();
            $db->connect();
                
            $collaborator = new Collaborator();
            $collaborator = $collaborator->getById($db,intval($args[0]));
            $servicesCollaborator = $collaborator->getServices($db);

            $services = new Service();
            $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        }else{
            Flash::set('resultUpdateCollaborator', 'Erro ao encontrar colaborador!','notification error');
            return redirect("/admin/service");
        }

        $this->view = 'admin/registerAndUploadCollaborator.php';
        $this->data = [
            'title'=>'Editar colaborador | AgendaFacil',
            'navActive'=>'colaboradores',
            'legend'=>'Editar colaborador',
            'buttonText'=>'Editar',
            'action'=>'/admin/collaborator/update/'.intval($args[0]),
            'collaborator'=>$collaborator,
            'services'=>$services,
            'servicesCollaborator'=>$servicesCollaborator,
            'breadcrumb'=>Breadcrumb::getForAdmin()
        ];

    }

    public function show(array $args){
        BlockNotAdmin::block($this,['show']);

        $idCollaborator = $this->sanitizeArgNumber($args[0]);
        if(isset($args) && $idCollaborator){
            $db = new Db();
            $db->connect();
                
            $service = new Service();
            $collaborator = new Collaborator();
            $collaborator = $collaborator->getById($db,$idCollaborator);
            $servicesId = $collaborator->getServices($db);
            $services = [];

            foreach ($servicesId as $id) {
                array_push($services,$service->getById($db,$id));
            }
        }else{
            Flash::set('resultUpdateCollaborator', 'Erro ao encontrar colaborador!','notification error');
            return redirect("/admin/service");
        }
        

        $this->view = 'admin/showCollaborator.php';
        $this->data = [
            'title'=>'Visualizar colaborador | AgendaFacil',
            'navActive'=>'colaboradores',
            'collaborator'=>$collaborator,
            'services'=>$services,
            'breadcrumb'=>Breadcrumb::getForAdmin()
        ];
    }

    public function getDataForDashboard(){
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        $idCollaborator = $this->sanitizeArgNumber($_GET['idCollaborator']);
        if(isset($_SESSION['collaborator']) && $_SESSION['auth'] && $idCollaborator){
            $db = new Db();
            $db->connect();
            $collaborators = new Collaborator();
            $schedules = new Schedule();
            $months = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
            $dataLine = ['schedules'=>[],'cancellations'=>[]];
            $schedules = $schedules->getByCollaborator($db,$idCollaborator,$_SESSION['collaborator']->getIdCompany());
            
            if(count($schedules) != 0){
                // data for line chart
                for($i=0; $i < 12; $i++){ 
                    $filteredSchedules = array_filter($schedules, function($schedule) use($i){
                        return $schedule->getDateSchedule()->format('m') == $i+1;
                    });
                    array_push($dataLine['schedules'],[$months[$i]=>count($filteredSchedules)]);

                    $filteredSchedules = array_filter($schedules, function($schedule) use($i){
                        return ($schedule->getDateSchedule()->format('m') == $i+1) && $schedule->getStatus() === 'cancelado';
                    });
                    array_push($dataLine['cancellations'],[$months[$i]=>count($filteredSchedules)]);
                }
            }else{
                $dataLine = 0;
            }
           
        
            header('Content-Type: application/json');
            echo json_encode($dataLine);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "collaborator" is required']);
        }
    }


    //TODO atualizar servicos do colab
    public function update(array $args){
        BlockNotAdmin::block($this,['update']);

        $idCollaborator = $this->sanitizeArgNumber($args[0]);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $idCollaborator){
                $db = new Db();
                $db->connect();
              
                $validate = new Validate();
                $collaborator = new Collaborator();
                $collaborator = $collaborator->getById($db,$idCollaborator);

                if($_POST['csrf_token']){
                    $validate->handle(['csrf_token'=>[CSRF]],'company');
                }else{
                    Flash::set('resultUpdateCollaborator', 'Erro ao editar colaborador!','notification error');
                    return redirect("/admin/collaborator");
                }

                if($_FILES['avatar'] && $_FILES['avatar']['error'] == 0){
                    $validate->handle(['avatar'=>[IMAGE]],'collaborator');
                    $collaborator->setAvatar($validate->data['avatar']['success'] ? $validate->data['avatar']['link'] : AVATAR_DEFAULT);
                }

                if($_POST['name'] && $collaborator->getName() !== $_POST['name']){
                    $validate->handle(['name'=>[REQUIRED]],'collaborator');
                    $collaborator->setName($validate->data['name']);
                }

                if($_POST['cpf'] && $collaborator->getCpf() !== $_POST['cpf']){
                    $validate->handle(['cpf'=>[CPF]],'collaborator');
                    $collaborator->setCpf($validate->data['cpf']);
                }

                if($_POST['phone'] && $collaborator->getPhone() !== $_POST['phone']){
                    $validate->handle(['phone'=>[REQUIRED]],'collaborator');
                    $collaborator->setPhone($validate->data['phone']);
                }

                if($_POST['email'] && $collaborator->getEmail() !== $_POST['email']){
                    $validate->handle(['email'=>[EMAIL]],'collaborator');
                    $collaborator->setEmail($validate->data['email']);
                }

                if($_POST['password'] && $collaborator->getPassword() !== $_POST['password'] && $_POST['password'] !== ""){
                    $validate->handle(['password'=>[PASSWORD]],'collaborator');
                    $collaborator->setPassword($validate->data['password']);
                }

                if($_POST['nivel']){
                    $validate->handle(['nivel'=>[REQUIRED]],'collaborator');
                    $collaborator->setNivel($validate->data['nivel']);
                }

                if($_POST['commission']){
                    $validate->handle(['commission'=>[REQUIRED]],'collaborator');
                    $collaborator->setCommission($validate->data['commission']);
                }

                if($_POST['active'] && $collaborator->getActive() != $_POST['active']){
                    $validate->handle(['active'=>[REQUIRED]],'servicevoucher');
                    $voucher->setActive($_POST['active']);
                }

                if($validate->errors) {
                    return redirect('/admin/collaborator/edit');
                }
                
                if($collaborator->update($db,$collaborator->getId())){
                    Flash::set('resultUpdateCollaborator', 'Colaborador editado com sucesso!','notification sucess');
                    return redirect("/admin/collaborator");
                }

                Flash::set('resultUpdateCollaborator', 'Erro ao editar colaborador!','notification error');
                return redirect("/admin/collaborator/edit/".$collaborator->getId());
        }else{
            Flash::set('resultUpdateCollaborator', 'Erro ao editar colaborador!','notification error');
            return redirect("/admin/collaborator/");
        }
        
     
    }

    //TODO conferir se ta inserindo desabilitado 
    //TODO conferir pq nao ta atualizando propriedade ativo

    public function store(array $args){
        BlockNotAdmin::block($this,['store']);
        $db = new Db();
        $db->connect();

        $services = new Service();
        $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        $services = $services['services'];

        $this->view = 'admin/registerAndUploadCollaborator.php';
        $this->data = [
            'title'=>'Cadastrar colaborador | AgendaFacil',
            'navActive'=>'colaboradores',
            'legend'=>'Cadastrar novo colaborador',
            'buttonText'=>'Cadastrar',
            'action'=>'/admin/collaborator/store',
            'services'=>$services,
            'servicesCollaborator'=>[],
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();

            $validateData = $this->validateCollaboratorData();
            $validateAvatar = $this->validateCollaboratorAvatar();
            $validateServices = $this->validateCollaboratorServices();
          
            if(!$validateData || !$validateServices){
            Flash::set('resultInsertCollaborator', 'Dados invalidos!','notification error');
                return redirect("/admin/collaborator/store");
            }

            $collaborator = $this->registerCollaborator($db,$validateData,$validateAvatar,$_SESSION['collaborator']->getIdCompany());
            $services = $this->registerCollaboratorServices($db,$validateServices,$collaborator->getId(),$_SESSION['collaborator']->getIdCompany());
            
            if(!$collaborator || !$services){
                Flash::set('resultInsertCollaborator', 'Erro ao cadastrar colaborador!','notification error');
                return redirect("/admin/collaborator/store");
            }

            Flash::set('resultInsertCollaborator', 'Colaborador cadastrado com sucesso!','notification sucess');
            unset($_SESSION['old']);
            return redirect("/admin/collaborator");
        }
    }

    private function validateCollaboratorData(){
        $validate = new Validate();
        $validate->handle([
            'active'=>[REQUIRED],
            'cpf'=>[CPF,REQUIRED],
            'name'=>[REQUIRED],
            'phone'=>[REQUIRED],
            'nivel'=>[REQUIRED],
            'commission'=>[REQUIRED],
            'email'=>[EMAIL,REQUIRED],
            'password'=>[PASSWORD,REQUIRED],
            'csrf_token'=>[CSRF]
        ],'collaborator');
        if($validate->errors) {
            return false;
        }
        return $validate;
    }

    private function validateCollaboratorAvatar(){
        $validate = new Validate();
        $validate->handle([
            'avatar'=>[IMAGE],
        ],'collaborator');
        if($validate->errors) {
            return false;
        }
        return $validate;
    }

    private function validateCollaboratorServices(){
        $arrayServices = [];
        if($_POST['services']){
            $services = $_POST['services'];
            foreach ($services as $service) {
                $service = htmlspecialchars($service, ENT_QUOTES, 'UTF-8');
                array_push($arrayServices,intval($service));
            }
            return $arrayServices;
        }
        return false;
    }

    private function registerCollaborator(Db $db,$validateData,$validateImage,$idCompany){
        $collaborator = new Collaborator(
            $validateImage->data['avatar']['success'] ? $validateImage->data['avatar']['link'] : AVATAR_DEFAULT,
            $validateData->data['name'],
            $validateData->data['cpf'],
            $validateData->data['phone'],
            $validateData->data['email'],
            $validateData->data['password'],
            $validateData->data['nivel'],
            $idCompany,new \DateTime(),1,
            0,$validateData->data['active'],
            $validateData->data['commission']);
            $collaborator->insert($db);
            $collaborator = $collaborator->getByEmail($db,$validateData->data['email']);
            unset($_SESSION['old']);
            return $collaborator ? $collaborator : false;
    }

    private function registerCollaboratorServices(Db $db,array $arrayIdServices,$idCollaborator,$idCompany){
        $collaborator = new Collaborator();
        $insertResult = true;
        foreach ($arrayIdServices as $idService) {
            if(!$collaborator->insertCollaboratorHasService($db,$idService,$idCollaborator,$idCompany)){
                $insertResult = false;
            }
        }
        return $insertResult;
    }


    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        if(isset($args[0]) && isset($args[1])){
            $idCollaborator = filter_var($args[0], FILTER_SANITIZE_NUMBER_INT);
            $used = $args[1];
            if(filter_var($idCollaborator, FILTER_VALIDATE_INT)){
                $db = new Db();
                $db->connect();
                $collaborator = new Collaborator();

                if($used){
                    $collaborator->setActive(0);
                    $collaborator->setIdCompany($_SESSION['collaborator']->getIdCompany());
                    if($collaborator->update($db,$idCollaborator)){
                        Flash::set('reultDeleteCollaborator', 'Colaborador inativado com sucesso!','notification sucess');
                        return redirect("/admin/collaborator");
                    }

                    Flash::set('reultDeleteCollaborator', 'Erro ao inativar colaborador!','notification error');
                    return redirect("/admin/collaborator");
                }else{
                    $collaborator->setIdCompany($_SESSION['collaborator']->getIdCompany());
                    if($collaborator->delete($db,$idCollaborator)){
                        Flash::set('reultDeleteCollaborator', 'Serviço excluido com sucesso!','notification sucess');
                        return redirect("/admin/collaborator");
                    }
                    Flash::set('reultDeleteCollaborator', 'Erro ao excluir colaborador!','notification error');
                    return redirect("/admin/collaborator");
                }

            }
        }else{
            Flash::set('reultDeleteService', 'Erro ao inativar serviço!','notification error');
            return redirect("/admin/service");
        }
    }

}

?>