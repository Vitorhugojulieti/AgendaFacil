<?php
namespace app\controllers\client;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Client;
use app\classes\GoogleClient;

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

    }

    public function show(array $args){

    }

    public function update(array $args){

    }

    public function store(){
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
        
        $db = new Db();
        $db->connect();
        $db->setTable('users');

        $client = new Client();
        $clientFound = $client->getByEmail($db,$email);

        if(!$clientFound){
            Flash::set('login','Usuario ou senha invalidos!');
            return redirect('/login');
        }

        // $passwordMatch = password_verify($password,$clientFound->getPassword());

        // var_dump($clientFound);
        // die();
        if(!($password === $clientFound->getPassword())){
            Flash::set('passwordLogin','Senha invalida!');
            return redirect('/login');
        }

        // if(!$passwordMatch){
        //     Flash::set('login','Senha invalida!');
        //     return redirect('/login');
        // }


        // unset($clientFound->password);
        $_SESSION['user'] = $clientFound;

        return redirect('/');
    }

    public function destroy(array $args){
        unset($_SESSION['user']);
        return redirect('/login');
    }
}

?>