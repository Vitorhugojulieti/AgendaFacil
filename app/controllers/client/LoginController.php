<?php
namespace app\controllers\client;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Client;
use app\classes\GoogleClient;
use app\classes\Authenticate;
use app\classes\Flash;
use app\classes\ContactEmail;


class LoginController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        $googleClient = new GoogleClient();
        $googleClient->init();
        $authUrl = $googleClient->generateAuthLink();

        $this->view = 'client/loginClient.php';
        $this->data = [
            'title'=>'Login | AgendaFacil',
            'linkGoogle'=>$authUrl,
        ];
    }

    public function edit(array $args){
        $this->view = 'forgotPassword.php';
        $this->data = [
            'title'=>'Redefinir senha | AgendaFacil',
            'action' => '/login/edit',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['email'])) {
                $db = new Db();
                $db->connect();

                $client = new Client();
                $client = $client->getByEmail($db,$_POST['email']);
                $_SESSION['userForgot'] = $client;

                if($client){
                    $token = bin2hex(random_bytes(50));
                    $_SESSION['resetPasswordToken'] = $token;
        
                    $resetLink = "http://localhost:8889/login/update/$token";
                    $message = "Clique no link para redefinir sua senha: $resetLink";

                    try {
                        $contactEmail = new ContactEmail();
                        $contactEmail->setTo(["email"=>$client->getEmail(),"name"=>$client->getName()]);
                        $contactEmail->setFrom(["email"=>"vitorhugo6331@outlook.com","name"=>"vitor"]);
                        $contactEmail->setSubject("Redefinir senha");
                        $contactEmail->setMessage($message);
                        $contactEmail->send();

                        Flash::set('redefinePassword',"Email enviado");
                        redirect("/login/edit");

                    } catch (\Throwable $th) {
                        var_dump($th);
                        die();
                    }
                }

                Flash::set('redefinePassword',"Email não cadastrado!");
                redirect("/login/edit");
            }
        }

    }

    public function show(array $args){

    }

    public function update(array $args){
        $this->view = 'redefinePassword.php';
        $this->data = [
            'title'=>'Redefinir senha | AgendaFacil',
            'action' => '/login/update',
        ];

        if(!in_array($_SESSION['resetPasswordToken'],$args)){
            redirect("/");
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(isset($_POST['password'])) {
                $db = new Db();
                $db->connect();

                $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

                $client = new Client();
                $client->setPassword($password);
                
                if($client->update($db,$_SESSION['userForgot']->getId())){
                    redirect("/login");
                }
            }
        }
        
     
    }

    public function store(array $args){
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

        if($email and $password){
            $db = new Db();
            $db->connect();
    
            $client = new Client();
            $clientFound = $client->getByEmail($db,$email);
    
            if(!$clientFound){
                Flash::set('login','Usuario ou senha invalidos!');
                return redirect('/login');
            }
    
            // $passwordMatch = password_verify($password,$clientFound->getPassword());
    
            // if(!$passwordMatch){
            //     Flash::set('loginPassword','Senha invalida!');
            //     return redirect('/login');
            // }
    
            if(!($password === $clientFound->getPassword())){
                Flash::set('loginPassword','Senha invalida!');
                return redirect('/login');
            }
    
            $clientFound->removeAttribute('password');
            $_SESSION['user'] = $clientFound;
            $_SESSION['auth'] = true;
    
            return redirect('/');
        }
        return redirect('/login');

    }

    public function loginGoogle(){
        $googleClient = new GoogleClient();
        $googleClient->init();
        if($googleClient->authorized()){
            $auth = new Authenticate();
            $auth->authGoogle($googleClient->getData());
        }
    }

    public function destroy(array $args){
        unset($_SESSION['user']);
        return redirect('/');
    }
}

?>