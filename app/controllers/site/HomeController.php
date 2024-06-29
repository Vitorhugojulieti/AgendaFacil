<?php
namespace app\controllers\site;
use app\models\database\Db;
use app\models\Client;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(){
        $this->view = 'formCadClient.php';
        // $db = new Db();
        // $db->connect();
        // $db->setTable('users');
        $user = new Client();
        $users = $user->getAll();
        var_dump($users[0]);
        die();
        $this->data = [
            'title'=>'Agenda facil',
        ];
    }
}

?>