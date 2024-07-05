<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Company;
use app\models\Collaborator;
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
        $this->view = 'admin/formCadCompany.php';
        $this->data = [
            'title'=>'Cadastre-se | AgendaFacil',
        ];

        $validate = new Validate();
        $validate->handle([
            'nameCompany'=>[REQUIRED],
            'phoneCompany'=>[REQUIRED],
            'cep'=>[REQUIRED],
            'adress'=>[REQUIRED],
            'emailCompany'=>[EMAIL],
            'cnpj'=>[CNPJ,REQUIRED],
            'cpfCompany'=>[CPF,REQUIRED],
            'name'=>[REQUIRED],
            'phone'=>[REQUIRED],
            'email'=>[EMAIL],
            'cpf'=>[CPF,REQUIRED],
            'password'=>[PASSWORD,REQUIRED]
        ]);

        if($validate->errors) {
            return redirect('/admin/signup');
        }


        //registration company
        $db = new Db();
        $db->connect();
        
        $linkLogo = $this->uploadImage($_FILES['logo']);
        $company = new Company($linkLogo,$validate->data['nameCompany'],"",$validate->data['cnpj'],$validate->data['phoneCompany'],$validate->data['emailCompany'],$validate->data['cep'],$validate->data['adress'],"free",$_POST['category'],date('d/m/y'),0);
        var_dump($company);
        $company->insert($db);

        //insert images company
        // $link = $_FILES['banner1'] && $_FILES['banner1'][0] == 0 ? $this->uploadImage($_FILES['banner1']) : false;
        // $link2 = $_FILES['banner2'] && $_FILES['banner2'][0] == 0 ? $this->uploadImage($_FILES['banner1']) : false;
        
        // $imageRegister = new Image($company->getId());
        // $imageRegister->setImage($link);
        // $imageRegister->insert();
        // $imageRegister->setImage($link2);
        // $imageRegister->insert();


        //registration collaborator manager
        $idCompany = $company->getIdByCnpj($db,$company->getCnpj());
        $linkAvatar = $this->uploadImage($_FILES['avatar']);
        $collaborator = new Collaborator($linkAvatar,$validate->data['name'],$validate->data['cpf'],$validate->data['phone'],$validate->data['email'],$validate->data['password'],"manager",$idCompany,date('d/m/y'),0);
        var_dump($collaborator);
        $collaborator->insert($db);

        //generate code confirm
        $code = CodeValidate::generate();
        $_SESSION['emailSend'] = $validate->data['email'];
        $_SESSION['nameSend'] = $validate->data['name'];


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
            $contactEmail->setTo(["email"=>$validate->data['email'],"name"=>$validate->data['name']]);
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