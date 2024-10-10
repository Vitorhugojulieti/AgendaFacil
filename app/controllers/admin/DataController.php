<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Company;
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
        ];
    }

    public function admin(array $args){
        
        $db = new Db();
        $db->connect();

       
        $this->view = 'admin/dataAdmin.php';
        $this->data = [
            'title'=>'Agenda facil',
            'admin'=>$_SESSION['collaborator'],
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'dataAdm',
            'actionCollaborator'=>'/admin/data/updateAdmin',
        ];
    }

    //TODO verificar horario final q nao atualiza
    //TODO mudar para atualizar com base no id da empresa logada somente e nao url
    public function updateCompany(array $args){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();
          
            $validate = new Validate();
            $company = new Company();
            $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());

            if($_POST['csrf_token']){
                $validate->handle(['csrf_token'=>[CSRF]],'company');
            }else{
                Flash::set('resultUpdateCompany', 'Erro ao dados da empresa colaborador!','notification error');
                return redirect("/admin/data");
            }

            if($_FILES['logo'] && $_FILES['logo']['error'] == 0){
                $validate->handle(['logo'=>[IMAGE]],'company');
                $company->setAvatar($validate->data['logo']['success'] ? $validate->data['logo']['link'] : AVATAR_DEFAULT);
            }

            if($_POST['name'] && $company->getName() !== $_POST['name']){
                $validate->handle(['name'=>[REQUIRED]],'company');
                $company->setName($validate->data['name']);
            }

            if($_POST['cnpj'] && $company->getCnpj() !== $_POST['cnpj']){
                $validate->handle(['cnpj'=>[CNPJ]],'company');
                $company->setCnpj($validate->data['cnpj']);
            }

            if($_POST['phone'] && $company->getPhone() !== $_POST['phone']){
                $validate->handle(['phone'=>[REQUIRED]],'company');
                $company->setPhone($validate->data['phone']);
            }

            if($_POST['category'] && $company->getCategory() !== $_POST['category']){
                $validate->handle(['category'=>[REQUIRED]],'company');
                $company->setCategory($validate->data['category']);
            }

            if($_POST['openingHoursMorningStart'] && $company->getOpeningHoursMorningStart() !== $_POST['openingHoursMorningStart']){
                $validate->handle(['openingHoursMorningStart'=>[TIME]],'company');
                $company->setOpeningHoursMorningStart($validate->data['openingHoursMorningStart']);
            }

            if($_POST['openingHoursMorningEnd'] && $company->getOpeningHoursMorningEnd() !== $_POST['openingHoursMorningEnd']){
                $validate->handle(['openingHoursMorningEnd'=>[TIME]],'company');
                $company->setOpeningHoursMorningEnd($validate->data['openingHoursMorningEnd']);
            }

            if($_POST['openingHoursAfternoonStart'] && $company->getOpeningHoursAfternoonStart() !== $_POST['openingHoursAfternoonStart']){
                $validate->handle(['openingHoursAfternoonStart'=>[TIME]],'company');
                $company->setOpeningHoursAfternoonStart($validate->data['openingHoursAfternoonStart']);
            }

            if($_POST['openingHoursAfternoonEnd'] && $company->getOpeningHoursAfternoonEnd() !== $_POST['openingHoursAfternoonEnd']){
                $validate->handle(['openingHoursAfternoonEnd'=>[TIME]],'company');
                $company->setOpeningHoursAfternoonEnd($validate->data['openingHoursAfternoonEnd']);
            }

            if($_POST['cep'] && $company->getCep() !== $_POST['cep']){
                $validate->handle(['cep'=>[REQUIRED]],'company');
                $company->setCep($validate->data['cep']);
            }

            if($_POST['road'] && $company->getRoad() !== $_POST['road']){
                $validate->handle(['road'=>[REQUIRED]],'company');
                $company->setRoad($validate->data['road']);
            }

            if($_POST['number'] && $company->getNumber() !== $_POST['number']){
                $validate->handle(['number'=>[REQUIRED]],'company');
                $company->setNumber($validate->data['number']);
            }

            if($_POST['city'] && $company->getCity() !== $_POST['city']){
                $validate->handle(['city'=>[REQUIRED]],'company');
                $company->setCity($validate->data['city']);
            }

            if($_POST['district'] && $company->getDistrict() !== $_POST['district']){
                $validate->handle(['district'=>[REQUIRED]],'company');
                $company->setDistrict($validate->data['district']);
            }

            if($_POST['state'] && $company->getState() !== $_POST['state']){
                $validate->handle(['state'=>[REQUIRED]],'company');
                $company->setState($validate->data['state']);
            }

            if($validate->errors) {
                return redirect('/admin/data');
            }
            

            if($company->update($db,$company->getId())){
                Flash::set('resultUpdateCompany', 'Dados da empresa editado com sucesso!','notification sucess');
                return redirect("/admin/data");
            }else{
                Flash::set('resultUpdateCompany', 'Erro ao dados da empresa colaborador!','notification error');
                return redirect("/admin/data");
            }

            return redirect("/admin/data");
        }
    }

    public function updateAdmin(array $args){
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