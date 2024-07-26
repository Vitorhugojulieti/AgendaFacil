<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Company;
use app\models\Collaborator;
use app\models\Images;
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

        $validateImages = $this->validateImages();
        $validateCompanyData = $this->validateCompanyData();
        $validateCompanyAddress = $this->validateCompanyAddress();
        $validateCollaboratorData = $this->validateCollaboratorData();
        if(!$validateImages || !$validateCompanyData || !$validateCompanyAddress || ! $validateCollaboratorData){
            return redirect('/admin/signup');
        }

        $db = new Db();
        $db->connect();
      
        $company = $this->registerCompany($db,$validateCompanyData,$validateCompanyAddress,$validateImages);
        $collaborator = $this->registerCollaborator($db,$validateCollaboratorData,$validateImages,$company);
        $images = $this->registerCompanyImages($db,$validateImages,$company);

        if(!$company || !$collaborator || !$images){
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
            'openingHoursStart'=>[TIME],
            'openingHoursEnd'=>[TIME],
                                                   
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
            'email'=>[EMAIL],
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

        if((isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) ){
            $validateImages->handle([
                'avatar'=>[IMAGE],
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

    private function registerCompany(Db $db,$validateData,$validateAdress,$validateImages){
        $company = new Company(
            $validateImages->data['logo']['success'] ? $validateImages->data['logo']['link'] : AVATAR_DEFAULT,
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
            "free",
            date('d/m/y'),
            0
            ,$validateData->data['openingHoursStart'],
            $validateData->data['openingHoursEnd']);
        $company->insert($db);
        $company = $company->getIdByCnpj($db, $validateData->data['cnpj']);
        return $company ? $company : false;
    }

    private function registerCollaborator(Db $db,$validateData,$validateImages,int $idCompany){
        $collaborator = new Collaborator(
            $validateImages->data['avatar']['success'] ? $validateImages->data['avatar']['link'] : AVATAR_DEFAULT,
            $validateData->data['name'],
            $validateData->data['cpf'],
            $validateData->data['phone'],
            $validateData->data['email'],
            $validateData->data['password'],
            "manager",
            $idCompany,
            date('d/m/y')
            ,0,
            true);
        return $collaborator->insert($db);
    }

    private function registerCompanyImages(Db $db,$validateImages,int $idCompany){
        $imageRegister = new Images(
            $idCompany,
            "Banner",
            $validateImages->data['avatar']['success'] ? $validateImages->data['avatar']['link'] : AVATAR_DEFAULT);
        return $imageRegister->insert($db);
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
    
                    redirect('/admin/home');
                }else{
                    Flash::set('confirmEmail','Codigo invalido!');
                    redirect('/admin/signup/confirmEmail');
                }
            }
        
        }
    }

    public function destroy(array $args){
        //code for delete company
    }
}

?>