<?php
namespace app\controllers;
use app\classes\Db;
use app\models\User;

class HomeController{
    public array $data = [];
    public string $view;

    public function index(){
        $this->view = 'redefinePassword.php';
        // $this->view = 'index_not_login.php';
        $this->data = [
            'title'=>'Agenda facil',
        ];
    }
}

?>