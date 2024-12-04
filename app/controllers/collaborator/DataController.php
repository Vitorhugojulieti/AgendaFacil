<?php
namespace app\controllers\collaborator;
use app\models\database\Db;
use app\models\Company;
use app\models\CompanyHours;
use app\models\Collaborator;
use app\classes\Old;
use app\classes\Breadcrumb;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Flash;

class DataController{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    public function index(array $args){
        
        $db = new Db();
        $db->connect();

        $company = new Company();
        $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());
       
       
        $this->view = 'admin/dataCompany.php';
        $this->data = [
            'title'=>'Agenda facil',
            'company'=>$company,
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'data',
            'actionCompany'=>'/admin/data/updateCompany',
            'activeCompany'=>$company->getRegistrationComplete() == 1 ? 'Empresa ativa' : 'Empresa inativa'
        ];
    }

    public function admin(array $args){
        
        $db = new Db();
        $db->connect();

        $company = new Company();
        $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());
        $activeCompany = $company->getRegistrationComplete() == 1 ? 'Empresa ativa' : 'Empresa inativa'; 
       
        $this->view = 'admin/dataAdmin.php';
        $this->data = [
            'title'=>'Agenda facil',
            'admin'=>$_SESSION['collaborator'],
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'dataAdm',
            'actionCollaborator'=>'/admin/data/updateAdmin',
            'activeCompany'=>$company->getRegistrationComplete() == 1 ? 'Empresa ativa' : 'Empresa inativa'

        ];
    }

    
    public function collaborator(array $args){
        
        $db = new Db();
        $db->connect();

        $company = new Company();
        $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());
        $activeCompany = $company->getRegistrationComplete() == 1 ? 'Empresa ativa' : 'Empresa inativa'; 
       
        $this->view = 'admin/dataAdmin.php';
        $this->data = [
            'title'=>'Agenda facil',
            'admin'=>$_SESSION['collaborator'],
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'dataAdm',
            'actionCollaborator'=>'/admin/data/updateAdmin',
            'activeCompany'=>$company->getRegistrationComplete() == 1 ? 'Empresa ativa' : 'Empresa inativa',
            'isCollaborator'=>true
        ];
    }


    public function store(array $args){
        // BlockNotAdmin::block($this,['updateAdmin']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $db = new Db();
                $db->connect();
              
                $validate = new Validate();
                $collaborator = new Collaborator();
                $collaborator = $collaborator->getById($db,$_SESSION['collaborator']->getId());

                if($_POST['csrf_token']){
                    $validate->handle(['csrf_token'=>[CSRF]],'collaborator');
                }else{
                    Flash::set('resultUpdateAdmin', 'Erro ao editar colaborador!','notification error');
                    return redirect("/admin/data/admin");
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

                if($validate->errors) {
                    return redirect('/admin/data');
                }
             
              
                if($collaborator->update($db,$collaborator->getId())){
                    Flash::set('resultUpdateAdmin', 'Colaborador editado com sucesso!','notification sucess');
                    $collaboratorManager = new Collaborator();
                    $_SESSION['collaborator'] = $collaboratorManager->getById($db,$collaborator->getId());
                    return redirect("/admin/data/admin");
                }else{
                    Flash::set('resultUpdateAdmin', 'Erro ao editar colaborador!','notification error');
                    return redirect("/admin/data/admin");
                }

                return redirect("/admin/data/admin");
        }
     
    }
}

?>