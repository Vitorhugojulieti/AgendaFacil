<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Collaborator;
use app\models\Company;
use app\classes\GoogleClient;
use app\classes\Authenticate;
use app\classes\Flash;
use app\classes\ContactEmail;


class LoginController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        $this->view = 'admin/loginCollaborator.php';
        $this->data = [
            'title'=>'Login | AgendaFacil',
        ];
    }

    public function edit(array $args){
        $this->view = 'forgotPassword.php';
        $this->data = [
            'title'=>'Redefinir senha | AgendaFacil',
            'action' => '/admin/login/edit',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['email'])) {
                $db = new Db();
                $db->connect();

                $collaboratorFound = new Collaborator();
                $collaboratorFound = $collaboratorFound->getByEmail($db,$_POST['email']);
                $_SESSION['collaboratorForgot'] = $collaboratorFound;

                if($collaboratorFound){
                    $token = bin2hex(random_bytes(50));
                    $_SESSION['resetPasswordToken'] = $token;
        
                    $resetLink = "http://localhost:8889/admin/login/update/$token";
                    $message = "Clique no link para redefinir sua senha: $resetLink";

                    try {
                        $contactEmail = new ContactEmail();
                        $contactEmail->setTo(["email"=>$collaboratorFound->getEmail(),"name"=>$collaboratorFound->getName()]);
                        $contactEmail->setFrom(["email"=>"vitorhugo6331@outlook.com","name"=>"vitor"]);
                        $contactEmail->setSubject("Redefinir senha");
                        $contactEmail->setMessage($message);
                        $contactEmail->send();

                        // TODO melhorar ui da mensagem
                        Flash::set('redefinePassword',"Se o endereço de e-mail estiver correto um link para redefinição da senha sera enviado!"," p-4");
                        redirect("/admin/login/edit");

                    } catch (\Throwable $th) {
                        var_dump($th);
                        die();
                    }
                }

                redirect("/admin/login/edit");
            }
        }

    }

    public function update(array $args){
        $this->view = 'redefinePassword.php';
        $this->data = [
            'title'=>'Redefinir senha | AgendaFacil',
            'action' => '/admin/login/update',
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(isset($_POST['password'])) {
                $db = new Db();
                $db->connect();

                $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

                $collaborator = new Collaborator();
                $collaborator = $collaborator->getByEmail($db,$_SESSION['collaboratorForgot']->getEmail());
                $collaborator->setPassword($password);
                
                if($collaborator->update($db,$_SESSION['collaboratorForgot']->getId())){
                    return redirect('/admin/login');
                }
            }
        }
        
        
        if(!in_array($_SESSION['resetPasswordToken'],$args)){
            return redirect('/admin/login');
        }
     
    }

    public function store(){
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

        if($email and $password){
            $db = new Db();
            $db->connect();
    
            $collaboratorFound = new Collaborator();
            $collaboratorFound = $collaboratorFound->getByEmail($db,$email);
    
            if(!$collaboratorFound){
                Flash::set('loginCollaborator','Usuario ou senha invalidos!');
                return redirect('/admin/login');
            }
    
            // $passwordMatch = password_verify($password,$collaboratorFound->getPassword());

            if(!($password === $collaboratorFound->getPassword())){
                Flash::set('loginCollaborator','Usuario ou senha invalidos!');
                return redirect('/admin/login');
            }
    
    
    
            $collaboratorFound->removeAttribute('password');
            $_SESSION['collaborator'] = $collaboratorFound;
            $_SESSION['auth'] = true;
    
            if($collaboratorFound->getNivel() == 'manager'){
                $db = new Db();
                $db->connect();
                $company = new Company();
                $company = $company->getById($db,$collaboratorFound->getIdCompany());
                setCompanyActive($company->getRegistrationComplete());
                return redirect('/admin/');
            }else if($collaboratorFound->getNivel() == 'collaborator'){
                return redirect('/collaborator/schedule');
            }
        }
        return redirect('/admin/login');

    }


    public function destroy(array $args){
        unset($_SESSION['collaborator']);
        unset($_SESSION['auth']);
        return redirect('/admin/login');
    }
}

?>