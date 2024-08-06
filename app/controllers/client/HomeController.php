<?php
namespace app\controllers\client;
use app\models\database\Db;
use app\models\Client;
use app\models\Company;
use app\models\Service;
use app\classes\Old;
use app\classes\Cart;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        Cart::delete();
        $db = new Db();
        $db->connect();
        $companys = new Company();
        $companys = $companys->getAll($db);

// logica para filtros
        // if(!isset($args)){
        //     $services = $services->getAll($db);
        //     var_dump($services);
        //     die();
        // }
       
        $this->view = 'home.php';
        $this->data = [
            'title'=>'Agenda facil',
            'companys'=>$companys,
        ];

        if(!isset($_SESSION['user']) || !isset($_SESSION['auth'])) {
            $this->view = 'indexNotLogin.php'; 
        }



    }
}

?>