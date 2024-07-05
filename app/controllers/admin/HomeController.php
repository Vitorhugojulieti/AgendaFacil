<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Client;
use app\models\Company;
use app\classes\Old;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    public function index(){
        $this->view = 'home.php';
        $this->data = [
            'title'=>'Agenda facil',
        ];

        var_dump("home admin");
        die();
    }
}

?>