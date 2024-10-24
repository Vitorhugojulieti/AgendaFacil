<?php
namespace app\controllers\admin;
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

       
        $this->view = 'admin/dataAdmin.php';
        $this->data = [
            'title'=>'Agenda facil',
            'admin'=>$_SESSION['collaborator'],
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'dataAdm',
            'actionCollaborator'=>'/admin/data/updateAdmin',
        ];
    }

    private function updateHours(){

        // else{
        //     Flash::set('resultUpdateCompany', 'Erro ao dados da empresa colaborador!','notification error');
        //     return redirect("/admin/data");
        // }
    }

    private function receiveAndOrganizeHours() {
        // Garantir que $days seja um array
        $days = isset($_POST['days']) && is_array($_POST['days']) ? $_POST['days'] : []; 
        $startHourMorning = isset($_POST['inputOpeningHoursMorningStart']) && is_array($_POST['inputOpeningHoursMorningStart']) ? $_POST['inputOpeningHoursMorningStart'] : []; 
        $endHourMorning = isset($_POST['inputOpeningHoursMorningEnd']) && is_array($_POST['inputOpeningHoursMorningEnd']) ? $_POST['inputOpeningHoursMorningEnd'] : []; 
        $startHourAfternoon = isset($_POST['inputOpeningHoursAfternoonStart']) && is_array($_POST['inputOpeningHoursAfternoonStart']) ? $_POST['inputOpeningHoursAfternoonStart'] : []; 
        $endHourAfternoon = isset($_POST['inputOpeningHoursAfternoonEnd']) && is_array($_POST['inputOpeningHoursAfternoonEnd']) ? $_POST['inputOpeningHoursAfternoonEnd'] : []; 
    
        // Array para agrupar horários comuns
        $groupedHours = [];
    
        foreach ($days as $index => $dayArray) {
            if (!is_array($dayArray)) {
                continue; // Ignorar se $dayArray não é um array
            }
    
            // Definir os horários de manhã e tarde para o índice atual
            $morningStart = isset($startHourMorning[$index]) ? $startHourMorning[$index] : null;
            $morningEnd = isset($endHourMorning[$index]) ? $endHourMorning[$index] : null;
            $afternoonStart = isset($startHourAfternoon[$index]) ? $startHourAfternoon[$index] : null;
            $afternoonEnd = isset($endHourAfternoon[$index]) ? $endHourAfternoon[$index] : null;
    
            // Criar uma chave única concatenando os horários (evitar objetos como chave)
            $scheduleKey = implode('-', array_filter([$morningStart, $morningEnd, $afternoonStart, $afternoonEnd]));
    
            // Agrupar os dias com os mesmos horários
            if (!isset($groupedHours[$scheduleKey])) {
                $groupedHours[$scheduleKey] = [
                    'days' => [],
                    'morningStart' => $morningStart,
                    'morningEnd' => $morningEnd,
                    'afternoonStart' => $afternoonStart,
                    'afternoonEnd' => $afternoonEnd,
                ];
            }
    
            // Adicionar os dias ao grupo de horários comuns
            foreach ($dayArray as $day) {
                $groupedHours[$scheduleKey]['days'][] = $day;
            }
        }
    
        return $groupedHours;
    }

    //TODO verificar horario final q nao atualiza
    //TODO mudar para atualizar com base no id da empresa logada somente e nao url
    public function updateCompany(array $args){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();
            $update = false;

            $hours = $this->receiveAndOrganizeHours();
            var_dump($hours);
            die();
            $hoursUpdate = $this->updateHours($hours);

            if($hoursUpdate){
                $update = true;
            }

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
                $update = true;
            }

            if($_POST['name'] && $company->getName() !== $_POST['name']){
                $validate->handle(['name'=>[REQUIRED]],'company');
                $company->setName($validate->data['name']);
                $update = true;
            }

            if($_POST['cnpj'] && $company->getCnpj() !== $_POST['cnpj']){
                $validate->handle(['cnpj'=>[CNPJ]],'company');
                $company->setCnpj($validate->data['cnpj']);
                $update = true;
            }

            if($_POST['phone'] && $company->getPhone() !== $_POST['phone']){
                $validate->handle(['phone'=>[REQUIRED]],'company');
                $company->setPhone($validate->data['phone']);
                $update = true;
            }

            if($_POST['category'] && $company->getCategory() !== $_POST['category']){
                $validate->handle(['category'=>[REQUIRED]],'company');
                $company->setCategory($validate->data['category']);
                $update = true;
            }

            if($_POST['cep'] && $company->getCep() !== $_POST['cep']){
                $validate->handle(['cep'=>[REQUIRED]],'company');
                $company->setCep($validate->data['cep']);
                $update = true;
            }

            if($_POST['road'] && $company->getRoad() !== $_POST['road']){
                $validate->handle(['road'=>[REQUIRED]],'company');
                $company->setRoad($validate->data['road']);
                $update = true;
            }

            if($_POST['number'] && $company->getNumber() !== $_POST['number']){
                $validate->handle(['number'=>[REQUIRED]],'company');
                $company->setNumber($validate->data['number']);
                $update = true;
            }

            if($_POST['city'] && $company->getCity() !== $_POST['city']){
                $validate->handle(['city'=>[REQUIRED]],'company');
                $company->setCity($validate->data['city']);
                $update = true;
            }

            if($_POST['district'] && $company->getDistrict() !== $_POST['district']){
                $validate->handle(['district'=>[REQUIRED]],'company');
                $company->setDistrict($validate->data['district']);
                $update = true;
            }

            if($_POST['state'] && $company->getState() !== $_POST['state']){
                $validate->handle(['state'=>[REQUIRED]],'company');
                $company->setState($validate->data['state']);
                $update = true;
            }

            if($validate->errors) {
                return redirect('/admin/data');
            }
            

            if($update){
                if($company->update($db,$company->getId())){
                    Flash::set('resultUpdateCompany', 'Dados da empresa editado com sucesso!','notification sucess');
                    return redirect("/admin/data");
                }else{
                    Flash::set('resultUpdateCompany', 'Erro ao dados da empresa colaborador!','notification error');
                    return redirect("/admin/data");
                } 
            }else if($hoursUpdate){
                Flash::set('resultUpdateCompany', 'Dados da empresa editado com sucesso!','notification sucess');
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