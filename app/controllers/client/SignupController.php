<?php
namespace app\controllers\client;
use app\models\database\Db;
use app\models\Client;
use app\classes\Validate;
use app\classes\ContactEmail;
use app\classes\ImageUpload;
use app\classes\Flash;

class SignupController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        $this->view = 'client/formCadClient.php';
        $this->data = [
            'title'=>'Cadastre-se | AgendaFacil',
        ];
    }

    public function store(){
        $db = new Db();
        $db->connect();

        $validate = new Validate();
        $validate->handle([
            'name'=>[REQUIRED],
            'phone'=>[REQUIRED],
            'email'=>[EMAIL],
            'cpf'=>[CPF,REQUIRED],
            'password'=>[PASSWORD,REQUIRED]
        ]);

        if($validate->errors) {
            return redirect('/signup');
        }

        //registration
        $registrationDate = date('d/m/y');
        $client = new Client("",$validate->data['name'],$validate->data['cpf'],$validate->data['phone'],$validate->data['email'],$validate->data['password'],$registrationDate,0);

        if($client->insert($db)){
            //generate code confirm
            $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $_SESSION['codeConfirmEmail'] = $code;
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

            //redirect confirm email
            redirect('/signup/confirmEmail');
        }
    }

    public function finishRegistration(){
        $this->view = 'finishRegistration.php';
        $this->data = [
            'title'=>'Finalizar cadastro| AgendaFacil',
        ];
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['phone']) && isset($_POST['cpf']) && isset($_POST['cpf'])) {
                $db = new Db();
                $db->connect();

                $phone = filter_input(INPUT_POST,'phone',FILTER_SANITIZE_EMAIL);
                $cpf = filter_input(INPUT_POST,'cpf',FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

                $client = new Client();
                $client->setPhone($phone);
                $client->setCpf($cpf);
                $client->setPassword($password);
                $client->setRegistrationComplete(true);
                $clientSession = $_SESSION['user'];
                $clientUpdate = $client->getByEmail($db,$clientSession->getEmail());

                $client->update($db,$clientUpdate->getId());
                $_SESSION['user']->setPhone($phone);
                //validar cpf?
                $_SESSION['user']->setCpf($cpf);
                $_SESSION['user']->setRegistrationComplete(1);

                redirect('/');
            }
        }
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
                
                if($_SESSION['codeConfirmEmail'] === $field1.$field2.$field3.$field4){
                    $client = new Client();
                    $client->setRegistrationComplete(1);
                    $client->setName("marcio");
                    $clientBD = $client->getByEmail($db,$_SESSION['emailSend']);
                    $client->update($db,$clientBD->getId());
                    $_SESSION['user'] = $clientBD;
    
                  
                    redirect('/signup/chooseAvatar');
                }else{
                    Flash::set('confirmEmail','Codigo invalido!');
                    redirect('/signup/confirmEmail');
                }
            }
        
        }


    }

    public function chooseAvatar(){
        $this->view = 'chooseAvatar.php';
        $this->data = [
            'title'=>'Selecione seu avatar | AgendaFacil',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $imgUpload = new ImageUpload();
                $return = $imgUpload->upload($_FILES['avatar']);

                if($return['success']){
                    $db = new Db();
                    $db->connect();
                    
                    $client = new Client();
                    $client->setAvatar($return['link']);
                    if($client->update($db,$_SESSION['user']->getId())){
                        $_SESSION['user']->setAvatar($return['link']);
                        $_SESSION['auth'] = true;
                        redirect("/");
                    }
                }else{
                    Flash::set('chooseAvatar',$return['message']);
                    redirect("/signup/chooseAvatar");
                }
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