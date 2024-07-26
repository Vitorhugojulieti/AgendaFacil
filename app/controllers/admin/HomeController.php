<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Client;
use app\models\Collaborator;
use app\models\Service;
use app\classes\Old;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    public function index(){
        $db = new Db();
        $db->connect();
   
        $service = new Service();
        $service->setIdCompany($_SESSION['collaborator']->getIdCompany());

        $this->view = 'admin/homeAdmin.php';
        $this->data = [
            'title'=>'Agenda facil',
            'navActive'=>'dashboard',
            'totalCollaborators'=>0,
            'totalServices'=>$service->totalRecords($db),
            'nameCollaborator'=>$_SESSION['collaborator']->getName(),
        ];

       
    }
}

?>