<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Client;
use app\models\Collaborator;
use app\models\Service;
use app\models\Schedule;
use app\models\Notification;
use app\classes\Old;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    public function index(){
        $db = new Db();
        $db->connect();
   
        //pegar total de serviços
        $services = new Service();
        $services->setIdCompany($_SESSION['collaborator']->getIdCompany());
        $services = $services->totalRecords($db);
        //pegar total de colaboradores
        $collaborators = new Collaborator();
        $collaborators->setIdCompany($_SESSION['collaborator']->getIdCompany());
        $collaborators = $collaborators->totalRecords($db);
        //pegar agenda
        $schedules = new Schedule();
        $schedules = $schedules->getByCompany($db,$_SESSION['collaborator']->getId());
        //pegar total de agendamentos
        $totalSchedules = count($schedules);
        //pegar total de recebimentos
        // $schedules = new Schedule();
        // $schedules->setIdCompany($_SESSION['collaborator']->getIdCompany());
        // $schedules = $schedules->totalRecords($db);

        $notification = new Notification(1,'dasd','sadas',new \DateTime(),0,1,0);
        $notification = $notification->insert($db);    
        
        $notifications = new Notification();
        $notifications = $notifications->getByCompany($db,$_SESSION['collaborator']->getIdCompany());

        $unmarkedNotifications = 0;

        foreach ($notifications as $notification) {
            if($notification->getNotified() === 0){
                $unmarkedNotifications += 1;
            }
        }

        $this->view = 'admin/homeAdmin.php';
        $this->data = [
            'title'=>'Agenda facil',
            'navActive'=>'dashboard',
            'totalCollaborators'=>$collaborators,
            'totalSchedules'=>$totalSchedules,
            'totalServices'=>$services,
            'nameCollaborator'=>$_SESSION['collaborator']->getName(),
            'notifications' =>$notifications,
            'unmarkedNotifications'=>$unmarkedNotifications,
        ];

       
    }

    public function getDataForDashboard(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        if (isset($_SESSION['collaborator'])){
            $db = new Db();
            $db->connect();
            $collaborators = new Collaborator();
            $services = new Service();
            $schedules = new Schedule();
            $months = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
            $dataLine = ['schedules'=>[],'cancellations'=>[]];
            $dataDonut = ['labels'=>[],'series'=>[]];
            $columnChar = [];

            // data for line chart
            for($i=0; $i < 12; $i++){ 
                array_push($dataLine['schedules'],[$months[$i]=>count($schedules->getByCompanyForMonth($db,$_SESSION['collaborator']->getIdCompany(),$i+1))]);
            }

            for($i=0; $i < 12; $i++){ 
                array_push($dataLine['cancellations'],[$months[$i]=>count($schedules->getByCompanyForMonthCancellations($db,$_SESSION['collaborator']->getIdCompany(),$i+1))]);
            }

            // data for donut Chart
            $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany());

            foreach ($services as $service) {
                array_push($dataDonut['labels'],$service->getName());
                array_push($dataDonut['series'],$schedules->getSchedulesByService($db,$_SESSION['collaborator']->getIdCompany(),$service->getId()));
            }
         
            // data for column chart 
            $collaborators = $collaborators->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
            foreach ($collaborators as $collaborator) {
                array_push($columnChar,['x'=>$collaborator->getName(),'y'=>$schedules->getSchedulesForCollaboratorByCompany($db,$_SESSION['collaborator']->getIdCompany(),$collaborator->getId())]);
            }

            $schedulesOfServices = [
                'lineChart'=>$dataLine,
                'donutChart'=>$dataDonut,
                'columnChart'=>$columnChar
            ];

            header('Content-Type: application/json');
            echo json_encode($schedulesOfServices);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Access denied']);
        }
    }
   
}

?>