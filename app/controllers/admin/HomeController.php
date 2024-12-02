<?php
namespace app\controllers\admin;
use app\models\database\Db;
use app\models\Client;
use app\models\Collaborator;
use app\models\Company;
use app\models\Service;
use app\models\Schedule;
use app\models\Notification;
use app\classes\Old;
use app\classes\Breadcrumb;


class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    public function index(){
        $db = new Db();
        $db->connect();

        $company = new Company();
        $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());

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
        //TODO criar metodo para pegar somente o total de agendametos
        $schedules = $schedules->getByCompany($db,$_SESSION['collaborator']->getId());
        //pegar total de agendamentos
        $totalSchedules = count($schedules);
        //pegar total de recebimentos
        //TODO criar busca pelo total de recebimentos
        $receipts = 0;
        foreach ($schedules as $schedule) {
            if($schedule->getStatus() == 'concluido'){
                $receipts = $receipts + $schedule->getTotalPaid();
            }
        }
        
        $notifications = new Notification();
        $notifications = $notifications->getByCompany($db,$_SESSION['collaborator']->getIdCompany());

        $unmarkedNotifications = 0;
        //TODO criar metodo para pegar total de nao lidas?

        foreach ($notifications as $notification) {
            if($notification->getNotified() === 0){
                $unmarkedNotifications += 1;
            }
        }

        $schedules = array_slice($schedules, 0, 5);

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
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'receipts'=>$receipts,
            'schedules'=>$schedules
        ];
    }

    public function getDataForDashboard(){
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        //TODO adicionar validacao de token 
        //TODO adicionar cabeçalhos para verificar origem da requisicao
        if(isset($_SESSION['collaborator']) && $_SESSION['auth'] && $_SESSION['collaborator']->getNivel() == 'manager'){
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
                $amountSchedules = count($schedules->getByCompanyForMonth($db,$_SESSION['collaborator']->getIdCompany(),$i+1));
                if($amountSchedules > 0){
                    array_push($dataLine['schedules'],[$months[$i]=>$amountSchedules]);
                }

                $amountCancellations = count($schedules->getByCompanyForMonthCancellations($db,$_SESSION['collaborator']->getIdCompany(),$i+1));
                if($amountCancellations > 0){
                    array_push($dataLine['cancellations'],[$months[$i]=> $amountCancellations]);
                }
            }

            // data for donut Chart
            $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany(),1,200);
            $services = $services['services'];

            if(count($services)>0){
                foreach ($services as $service) {
                    array_push($dataDonut['labels'],$service->getName());
                    array_push($dataDonut['series'],$schedules->getSchedulesByService($db,$_SESSION['collaborator']->getIdCompany(),$service->getId()));
                }
            }
         
            // data for column chart 
            $collaborators = $collaborators->getByCompany($db,$_SESSION['collaborator']->getIdCompany(),1,200);
            $collaborators = $collaborators['collaborators'];

            if(count($collaborators) > 0){
                foreach ($collaborators as $collaborator) {
                    array_push($columnChar,['x'=>$collaborator->getName(),'y'=>$schedules->getSchedulesForCollaboratorByCompany($db,$_SESSION['collaborator']->getIdCompany(),$collaborator->getId())]);
                }
            }
           
            if(count($collaborators) > 0 && count($services) > 0 && count($dataLine['schedules'])>0 && count($dataLine['cancellations'])>0){
                usort($columnChar, fn($a, $b) => $b['y'] <=> $a['y']);
                $columnChar = array_slice($columnChar, 0, 5);
                
                $schedulesOfServices = [
                    'lineChart'=>$dataLine,
                    'donutChart'=>$dataDonut,
                    'columnChart'=>$columnChar
                ];
            }else{
                $schedulesOfServices = 0;
            }
          

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