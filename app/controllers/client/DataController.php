<?php
namespace app\controllers\client;
use app\models\database\Db;
use app\models\Client;
use app\models\Company;
use app\models\Service;
use app\classes\Old;

class DataController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
       
        $this->view = 'client/dataUser.php';
        $this->data = [
            'title'=>'Agenda facil',
        ];

        if(!isset($_SESSION['user']) || !isset($_SESSION['auth'])) {
            $this->view = 'indexNotLogin.php'; 
        }



    }
}

?>