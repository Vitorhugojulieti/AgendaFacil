<?php
namespace app\controllers\collaborator;
use app\models\database\Db;
use app\models\Client;
use app\models\Company;
use app\models\Schedule;
use app\classes\Old;
use app\classes\Cart;
use app\classes\Validate;
use app\classes\Breadcrumb;
use app\classes\Flash;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){

        $this->view = 'collaborator/homeCollaborator.php';
        $this->data = [
            'title'=>'Agenda facil',
            'collaborator'=>$_SESSION['collaborator'],
        ];

    }

 
    
}

?>