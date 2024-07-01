<?php
namespace app\controllers\client;
use app\models\database\Db;
use app\models\Client;
use app\classes\Old;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(){
        $this->view = 'home.php';
        $db = new Db();
        $db->connect();
        $db->setTable('users');

        $client = new Client();
        // $clients = $client->getAll($db);
        // $client = $client->getById($db,10);
        // $client->setAvatar('clwewqeqweqweqweqeitin');
        // $client->setName('testandoUPDAte');
        // $client->setCpf('333.333.333-00');
        // $client->setPhone('1899898978');
        // $client->setEmail('teste@gmail.xom');
        // $client->setPassword('cl12121212eitin');
        // $client->setRegistrationDate('12/12/12');
        // var_dump($clients);
        // var_dump($client->insert($db));
        // var_dump($client->update($db,10));
        // $email = "vitorhugojusslieti@gmail.com";
        // var_dump($client->emailIsUsed($db,$email));
        // var_dump($client->emailHasPassword($db,$email));
        // var_dump("estou na homeeeee");
        // var_dump($_SESSION['user']);
        // die();
        // $client = $client->getByEmail($db,$email);
        // var_dump($client);
        // die();

        $this->data = [
            'title'=>'Agenda facil',
        ];
    }
}

?>