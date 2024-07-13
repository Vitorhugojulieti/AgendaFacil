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
use app\classes\CodeValidate;

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
        //validations
        $valid = true;

        //step 1
        $validateDataCompany = new Validate();
        $validateDataCompany->handle([
            // company
            'nameCompany'=>[REQUIRED],
            'phoneCompany'=>[REQUIRED],
            'cnpj'=>[CNPJ,REQUIRED],
            'category'=>[REQUIRED],
        ],'company');

        if($validateDataCompany->errors) {
            Flash::set('validDataCompany', 'invalid');
            $valid = false;
        }


        //step 2
        $validateDataCompany2 = new Validate();
        $validateDataCompany2->handle([
            'cep'=>[REQUIRED],
            'road'=>[REQUIRED],
            'state'=>[REQUIRED],
            'city'=>[REQUIRED],
            'number'=>[REQUIRED],
        ],'company');

        if($validateDataCompany2->errors) {
            Flash::set('validDataCompany2', 'invalid');
            $valid = false;
        }

        //step 3
        $validateClient = new Validate();
        $validateClient->handle([
            // collaborator
            'name'=>[REQUIRED],
            'phone'=>[REQUIRED],
            'email'=>[EMAIL],
            'cpf'=>[CPF,REQUIRED],
            'password'=>[PASSWORD,REQUIRED],
            'avatar'=>[IMAGE],
        ],'client');

        if($validateClient->errors) {
            Flash::set('validateClient', 'invalid');
            $valid = false;
        }


        //step 4
        $validaImages = new Validate();
        $validaImages->handle([
            // collaborator
            'logo'=>[IMAGE],
            'banner1'=>[IMAGE],
            'banner2'=>[IMAGE],
            'avatar'=>[IMAGE],
        ],'client');

        if($validaImages->errors) {
            Flash::set('validaImages', 'invalid');
            $valid = false;
        }

    
        if(!$valid) {
            return redirect('/admin/signup');
        }

        //registration
        $db = new Db();
        $db->connect();

        //registration company
        $company = new Company($validaImages->data['logo']['success'] ? $validaImages->data['logo']['link'] : AVATAR_DEFAULT,$validateDataCompany->data['nameCompany'],"",$validateDataCompany->data['cnpj'],$validateDataCompany->data['phoneCompany'],$validateDataCompany->data['category'],$validateDataCompany2->data['cep'],$validateDataCompany2->data['road'],$validateDataCompany2->data['number'],$validateDataCompany2->data['state'],$validateDataCompany2->data['city'],"free",date('d/m/y'),0);
        var_dump($company);
        $company->insert($db);

        //registration collaborator manager
        $idCompany = $company->getIdByCnpj($db,$company->getCnpj());
        $collaborator = new Collaborator($validateClient->data['avatar']['success'] ? $validateClient->data['avatar']['link'] : AVATAR_DEFAULT,$validateClient->data['name'],$validateClient->data['cpf'],$validateClient->data['phone'],$validateClient->data['email'],$validateClient->data['password'],"manager",$idCompany,date('d/m/y'),0);
        var_dump($collaborator);
        $collaborator->insert($db);

        //registration images company
        $imageRegister = new Images($idCompany,"Banner",$validaImages->data['banner1']['success'] ?$validaImages->data['banner1']['link'] : "");
        // var_dump($imageRegister);
        // die();
        $imageRegister->insert($db);
        $imageRegister->setLink($validaImages->data['banner2']['success'] ?$validaImages->data['banner2']['link'] : "");
        $imageRegister->insert($db);

        //generate code confirm
        $code = CodeValidate::generate();
        $_SESSION['emailSend'] = $validateClient->data['email'];
        $_SESSION['nameSend'] = $validateClient->data['name'];

         //message for email
         $message= "
         <div>
             <h1>Bem vindo ao Agenda Facil!</h1>
             <h2>Confirme seu E-mail</h2>
             <p>Codigo para confirmacaoo: {$code}</p>
         </div>";
                
        //send email
        try {
            $contactEmail = new ContactEmail();
            $contactEmail->setTo(["email"=>$validateClient->data['email'],"name"=>$validateClient->data['name']]);
            $contactEmail->setFrom(["email"=>"vitorhugo6331@outlook.com","name"=>"vitor"]);
            $contactEmail->setSubject("Confirmar E-mail");
            $contactEmail->setMessage($message);
            $contactEmail->send();

        } catch (\Throwable $th) {
            var_dump($th);
            die();
        }

        redirect("/admin/signup/confirmEmail");
    }

  
    public function confirmEmail(array $args){
        $this->view = 'confirmEmail.php';
        $this->data = [
            'title'=>'Confirmar email | AgendaFacil',
            'emailSend'=>$_SESSION['emailSend'] ? $_SESSION['emailSend'] : "",
            'action'=>'/admin/signup/confirmEmail',
        ];
        
        if(in_array('resend',$args)){
            $this->resendEmail();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['field1']) && isset($_POST['field2']) && isset($_POST['field3']) && isset($_POST['field4'])) {
                $db = new Db();
                $db->connect();

                $field1 = filter_input(INPUT_POST,'field1',FILTER_SANITIZE_STRING);
                $field2 = filter_input(INPUT_POST,'field2',FILTER_SANITIZE_STRING);
                $field3 = filter_input(INPUT_POST,'field3',FILTER_SANITIZE_STRING);
                $field4 = filter_input(INPUT_POST,'field4',FILTER_SANITIZE_STRING);
                
                if(CodeValidate::get() === $field1.$field2.$field3.$field4){
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

    public function uploadImage($file){

            if(isset($file) && $file['error'] == 0) {
                $imgUpload = new ImageUpload();
                $return = $imgUpload->upload($file);

                if($return['success']){
                    return $return['link'];
                    
                }else{
                    Flash::set('chooseAvatar',$return['message']);
                    redirect("/admin/signup");
                }
            }
    }

    public function resendEmail(){
        //generate code confirm
        $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $_SESSION['codeConfirmEmail'] = $code;
        //message for email
        $message= "
               <div>
                    <h1>Bem vindo ao Agenda Facil!</h1>
                    <h2>Confirme seu E-mail</h2>
                    <p>Codigo para confirmacaoo: {$code}</p>
                </div>";
                
        //send email
        try {
            $contactEmail = new ContactEmail();
            $contactEmail->setTo(["email"=>$_SESSION['emailSend'],"name"=>$_SESSION['nameSend']]);
            $contactEmail->setFrom(["email"=>"vitorhugo6331@outlook.com","name"=>"vitor"]);
            $contactEmail->setSubject("Confirmar E-mail");
            $contactEmail->setMessage($message);
            $contactEmail->send();


        } catch (\Throwable $th) {
            var_dump($th);
            die();
        }
    }

    public function destroy(array $args){

    }
}

?>