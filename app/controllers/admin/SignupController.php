<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Company;
use app\models\CompanyHours;
use app\models\Collaborator;
use app\models\Images;
use app\models\Notification;
use app\classes\Validate;
use app\classes\ContactEmail;
use app\classes\ImageUpload;
use app\classes\Flash;
use app\classes\CodeGenerator;

class SignupController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        $this->view = 'admin/formCadCompany.php';
        $this->data = [
            'title'=>'Cadastre-se | AgendaFacil',
        ];
    }

    public function store(){
        $validateCompanyData = $this->validateCompanyData();
        $validateCompanyAddress = $this->validateCompanyAddress();
        $validateCollaboratorData = $this->validateCollaboratorData();
        if(!$validateCompanyData || !$validateCompanyAddress || ! $validateCollaboratorData){
            return redirect('/admin/signup');
        }

        $db = new Db();
        $db->connect();
      
        $company = $this->registerCompany($db,$validateCompanyData,$validateCompanyAddress);
        $collaborator = $this->registerCollaborator($db,$validateCollaboratorData,$company);

        if(!$company || !$collaborator){
            Flash::set('registrationCompany', 'Erro ao registrar empresa');
            return redirect('/admin/signup');
        }
        
        $_SESSION['emailSend'] = $validateCollaboratorData->data['email'];
        $_SESSION['nameSend'] = $validateCollaboratorData->data['name'];

        $this->sendConfirmationEmail($validateCollaboratorData->data['name'],$validateCollaboratorData->data['email']);
        redirect("/admin/signup/confirmEmail");
    }

    private function validateCompanyData(){
        $validateCompanyData = new Validate();
        $validateCompanyData->handle([
            'nameCompany'=>[REQUIRED],
            'phoneCompany'=>[REQUIRED],
            'cnpj'=>[CNPJ,REQUIRED],
            'category'=>[REQUIRED],
        ],'company');
      
        if($validateCompanyData->errors) {
            Flash::set('validDataCompany', 'invalid');
            return false;
        }
        return $validateCompanyData;
    }

    private function validateCompanyAddress(){
        $validateCompanyAddress = new Validate();
        $validateCompanyAddress->handle([
            'cep'=>[REQUIRED],
            'road'=>[REQUIRED],
            'state'=>[REQUIRED],
            'city'=>[REQUIRED],
            'district'=>[REQUIRED],
            'number'=>[REQUIRED],
        ],'company');

        if($validateCompanyAddress->errors) {
            Flash::set('validDataCompany2', 'invalid');
            return false;
        }
        return $validateCompanyAddress;
    }

    private function validateCollaboratorData(){
        $validateCollaboratorData = new Validate();
        $validateCollaboratorData->handle([
            'name'=>[REQUIRED],
            'phone'=>[REQUIRED],
            'email'=>[EMAIL,REQUIRED],
            'cpf'=>[CPF,REQUIRED],
            'password'=>[PASSWORD,REQUIRED],
        ],'client');

        if($validateCollaboratorData->errors) {
            Flash::set('validClient', 'invalid');
            return false;
        }
        return  $validateCollaboratorData;
    }

    private function validateImages(){
        $validateImages = new Validate();

        if((isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) ){
            $validateImages->handle([
                'logo'=>[IMAGE],
            ],'client');
        }

        if((isset($_FILES['image']) && $_FILES['image']['error'] == 0) ){
            $validateImages->handle([
                'image'=>[IMAGE],
            ],'client');
        }

        if($validateImages->errors) {
            Flash::set('validImages', 'invalid');
            return false;
        }
        return $validateImages;
    }

    private function registerCompany(Db $db,$validateData,$validateAdress){
        $company = new Company(
            IMAGE_DEFAULT,
            $validateData->data['nameCompany'],
            $validateData->data['cnpj'],
            $validateData->data['phoneCompany'],
            $validateData->data['category'],
            $validateAdress->data['cep'],
            $validateAdress->data['road'],
            $validateAdress->data['number'],
            $validateAdress->data['district'],
            $validateAdress->data['state'],
            $validateAdress->data['city'],
            "free",'',
            0
           );
        $company->insert($db);
        $company = $company->getIdByCnpj($db, $validateData->data['cnpj']);
        unset($_SESSION['old']);
        return $company ? $company : false;
    }

    private function registerCollaborator(Db $db,$validateData,int $idCompany){
        $collaborator = new Collaborator(
            AVATAR_DEFAULT,
            $validateData->data['name'],
            $validateData->data['cpf'],
            $validateData->data['phone'],
            $validateData->data['email'],
            $validateData->data['password'],
            "manager",
            $idCompany,
            new \DateTime()
            ,1,
            1,floatval(0));
        unset($_SESSION['old']);
        return $collaborator->insert($db);
    }

    private function registerCompanyImages(Db $db,$validateImages,int $idCompany){
        $company = new Company();
        $company = $company->getById($db,$idCompany);
        $company->setLogo($validateImages->data['logo']['success'] ? $validateImages->data['logo']['link'] : IMAGE_DEFAULT);
        
        $registerImage = new Images(
            $idCompany,
            "image",
            $validateImages->data['image']['success'] ? $validateImages->data['image']['link'] : IMAGE_DEFAULT);

        
        if($company->update($db,$idCompany) && $registerImage->insert($db)){
            return true;
        }

        return false;
    }

    private function sendConfirmationEmail(String $name,String $email){
        if(ContactEmail::sendConfirmationEmail($name,$email)){
            return true;
        }
        Flash::set('sendEmail','Erro ao enviar e-mail!');
        return false;
    }
  
    public function confirmEmail(array $args){
        $this->view = 'confirmEmail.php';
        $this->data = [
            'title'=>'Confirmar email | AgendaFacil',
            'emailSend'=>$_SESSION['emailSend'] ? $_SESSION['emailSend'] : "",
            'action'=>'/admin/signup/confirmEmail',
        ];
        
        if(in_array('resend',$args)){
            $this->sendConfirmationEmail( $_SESSION['nameSend'], $_SESSION['emailSend']);
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['field1']) && isset($_POST['field2']) && isset($_POST['field3']) && isset($_POST['field4'])) {
                $db = new Db();
                $db->connect();

                $field1 = filter_input(INPUT_POST,'field1',FILTER_SANITIZE_STRING);
                $field2 = filter_input(INPUT_POST,'field2',FILTER_SANITIZE_STRING);
                $field3 = filter_input(INPUT_POST,'field3',FILTER_SANITIZE_STRING);
                $field4 = filter_input(INPUT_POST,'field4',FILTER_SANITIZE_STRING);
                
                if(CodeGenerator::get() === $field1.$field2.$field3.$field4){
                    $collaborator = new Collaborator();
                    $collaborator =  $collaborator->getByEmail($db,$_SESSION['emailSend']);
                    $collaborator->setRegistrationComplete(1);
                    $collaborator->update($db,$collaborator->getId());
                    $_SESSION['collaborator'] = $collaborator;
                    $_SESSION['auth'] = true;

                    
                    $db = new Db();
                    $db->connect();
                    $notification = new Notification(
                        0,
                        'Conclua o cadastro da empresa!',
                        '/admin/signup/completeRegistration',
                        new \DateTime(),
                        0,
                        $_SESSION['collaborator']->getIdCompany(),
                        0
                    );

                    $notification->insert($db);
    
                    redirect('/admin/home');
                }else{
                    Flash::set('confirmEmail','Codigo invalido!');
                    redirect('/admin/signup/confirmEmail');
                }
            }
        
        }
    }


    public function completeRegistration($args){
        $this->view = 'admin/completeRegistration.php';

        if(isset($args[0])){
            $idNotification = $args[0];
        }


     

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $complete = true;
            $db = new Db();
            $db->connect();

            // $idNotificationPost = $_POST['idNotification'];
            // $notification = new Notification();
            // $notification = $notification->getById($db,$idNotificationPost);

            $days = isset($_POST['days']) ? $_POST['days'] : ''; 
            $startHourMorning = isset($_POST['inputOpeningHoursMorningStart']) ? $_POST['inputOpeningHoursMorningStart'] : ''; 
            $endHourMorning = isset($_POST['inputOpeningHoursMorningEnd']) ? $_POST['inputOpeningHoursMorningEnd'] : ''; 

            $startHourAfternoon = isset($_POST['inputOpeningHoursAfternoonStart']) ? $_POST['inputOpeningHoursAfternoonStart'] : ''; 
            $endHourAfternoon = isset($_POST['inputOpeningHoursAfternoonEnd']) ? $_POST['inputOpeningHoursAfternoonEnd'] : ''; // Horários de término

            if($days == "" || $startHourMorning == "" ||  $endHourAfternoon == ""){
                Flash::set('completeRegistration','Erro ao concluir cadastro!');
                redirect('/admin/signup/confirmEmail/'.$idNotificationPost);
            }

            foreach ($days as $index => $dayArray) {
                if($endHourMorning != "" && $startHourAfternoon != ""){
                    $startHourMorning = $startHourMorning[$index]; 
                    $endHourMorning = $endHourMorning[$index]; 
    
                    $startHourAfternoon = $startHourAfternoon[$index]; 
                    $endHourAfternoon = $endHourAfternoon[$index]; 
            
                    foreach ($dayArray as $day) {
                        $companyHours = new CompanyHours($_SESSION['collaborator']->getIdCompany(),
                                                        $day,
                                                        new \DateTime($startHourMorning),
                                                        new \DateTime($endHourMorning),
                                                        new \DateTime($startHourAfternoon),
                                                        new \DateTime($endHourAfternoon));
                        if(!$companyHours->insert($db)){
                            $complete = false;
                        }
                        unset($companyHours);
                    }
                }else{
                    $startHourMorning = $startHourMorning[$index]; // Horário de início para esse índice
                    $endHourAfternoon = $endHourAfternoon[$index]; // Horário de término para esse índice
            
                    foreach ($dayArray as $day) {
                        $companyHours = new CompanyHours($_SESSION['collaborator']->getIdCompany(),
                                                        $day,
                                                        new \DateTime($startHourMorning),
                                                        new \DateTime('00:00:00'),
                                                        new \DateTime('00:00:00'),
                                                        new \DateTime($endHourAfternoon));
                        if(!$companyHours->insert($db)){
                            $complete = false;
                        }
                        unset($companyHours);
                    }
                }
                
            }
            $validateImages = $this->validateImages();
         
            if(!$validateImages){
                Flash::set('resultCompleteRegistration', 'Erro ao concluir cadastro!','notification error');
                return redirect("/admin/signup/completeRegistration".$idNotificationPost);
            }

            $images = $this->registerCompanyImages($db,$validateImages,$_SESSION['collaborator']->getIdCompany());

            if(!$images){
                $complete = false;
            }

            if(!$complete){
                Flash::set('resultCompleteRegistration', 'Erro ao concluir cadastro!','notification error');
                return redirect("/admin/signup/completeRegistration".$idNotificationPost);
            }

            $company = new Company();
            $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());
            $company->setRegistrationComplete(1);
            $company->update($db,$_SESSION['collaborator']->getIdCompany());
            $_SESSION['activeCompany'] = 1;

            // $notification->setNotified(1);
            // $notification->update($db,$_SESSION['collaborator']->getIdCompany());

            Flash::set('resultCompleteRegistration', 'Cadastro finalizado!','notification sucess');
            return redirect("/admin/");
        }

        $this->data = [
            'title'=>'Concluir cadastro | AgendaFacil',
            // 'idNotification'=>$idNotification
        ];
    }

    public function destroy(array $args){
        //code for delete company
    }
}

?>