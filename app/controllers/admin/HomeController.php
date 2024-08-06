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

    public function getDataForDashboard(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        if (isset($_GET['day'])) {
            $db = new Db();
            $db->connect();
            
            
        
            header('Content-Type: application/json');
            echo json_encode($availableTimes);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "day" is required']);
        }
    }
   
}

?>