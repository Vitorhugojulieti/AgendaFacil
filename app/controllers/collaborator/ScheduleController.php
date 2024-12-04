<?php
namespace app\controllers\collaborator;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Schedule;
use app\models\ScheduleOrder;
use app\models\Service;
use app\models\Company;
use app\models\Client;
use app\models\Collaborator;
use app\models\Images;
use app\classes\Flash;
use app\classes\Validate;
use app\classes\Breadcrumb;
use app\classes\BlockNotAdmin;
use app\classes\Cart;

class ScheduleController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    private function sanitizeArgNumber($number){
        $sanitizedAgument = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
        return intval($sanitizedAgument);
    }

   

    public function index(array $args){
        $db = new Db();
        $db->connect();
        $schedules = new Schedule();

        $currentPage = 1;
        $recordsPerPage = 10;

        if(isset($args[0])){
            $currentPage = intval($args[0]);
        }
     

        $startDate = isset($_GET['startDate']) ? intval($_GET['startDate']) : '';
        $endDate = isset($_GET['endDate']) ? intval($_GET['endDate']) : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';

      
    
        if (!isset($_GET['startDate']) && !isset($_GET['endDate']) && !isset($_GET['status'])) {
            $result = $schedules->getByCompanyPaginate($db, $_SESSION['collaborator']->getIdCompany(), $currentPage, $recordsPerPage);
        } else {
            $result = $schedules->getSchedulesByCollaboratorByFilters(
                $db,
                $_SESSION['collaborator']->getId(),
                $status,
                $startDate,
                $endDate,
                $currentPage,
                $recordsPerPage
            );
        }
    
        $pagination = $result['pagination'];
        $schedules = $result['schedules'];



        $this->view = 'admin/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'navActive'=>'agenda',
            'schedules'=>$schedules,
            'pagination'=>$pagination,
            'isCollaborator'=>true
        ];
    }


    public function getSchedules(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        if (isset($_GET['start']) && isset($_GET['end']) ) {
            $startDate = new \DateTime($_GET['start']);
            $endDate = new \DateTime($_GET['end']);

            $db = new Db();
            $db->connect();

            $client = new Client();
            $schedules = new Schedule();
            $schedules = $schedules->getByCollaborator($db,$_SESSION['collaborator']->getId(),$startDate,$endDate);
            $schedules = $schedules['schedules'];
            
            $arrayFormatedSchedules = [];

            foreach ($schedules as $schedule) {
                if($schedule->getStatus() != 'cancelado'){
                    array_push($arrayFormatedSchedules, [
                        'id' => $schedule->getId(),
                        'title' => ' - '.$client->getById($db,$schedule->getIdClient())->getName(),
                        'start' => (new \DateTime($schedule->getDateSchedule()->format('Y-m-d') . ' ' . $schedule->getStartTime()->format('H:i:s')))->format('Y-m-d H:i:s'),
                        'end' => (new \DateTime($schedule->getDateSchedule()->format('Y-m-d') . ' ' . $schedule->getEndTime()->format('H:i:s')))->format('Y-m-d H:i:s')
                    ]);
                }
            }

           

            header('Content-Type: application/json');
            echo json_encode($arrayFormatedSchedules);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "start" and "end" is required']);
        }
    }


    public function edit(array $args){

        $this->view = 'admin/registerAndUploadService.php';
        $this->data = [
            'title'=>'Editar serviço | AgendaFacil',
            'id'=>intval($args[0]),
            'navActive'=>'servicos',
            'legend'=>'Editar serviço',
            'action'=>'/admin/service/update',
            'service'=>$service,
        ];

    }


    public function show(array $args){
        if(isset($args)){
            $db = new Db();
            $db->connect();
            
            $schedule = new Schedule();
            $schedule = $schedule->getById($db,intval($args[0]));
            $orders = new ScheduleOrder();
            $orders = $orders->getBySchedule($db,intval($args[0]));

            $arrayReason = [['label'=>'Mudança de data/hora solicitada','value'=>'mudança de data/hora solicitada'],
            ['label'=>'Imprevisto do cliente','value'=>'imprevisto do cliente'],
            ['label'=>'Imprevisto do prestador de serviço','value'=>'imprevisto do prestador de serviço'],
            ['label'=>'Outro','value'=>'outro']];

            $actionCancel = '/admin/schedule/cancel';
            $actionComplete = '/admin/schedule/complete';
            $linkBack = '/admin/schedule';

        }

        $this->view = 'client/showSchedule.php';
        $this->data = [
            'title'=>'Visualizar agendamento | AgendaFacil',
            'schedule'=>$schedule,
            'orders'=>$orders,
            'reasons'=>$arrayReason,
            'actionCancel'=>$actionCancel,
            'actionComplete'=>$actionComplete,
            'linkBack'=>$linkBack

        ];
    }

    public function update(array $args){

    }

   
    public function store(array $args){
    }


    public function cancel(array $args){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $validate = new Validate();
            if($_POST['idSchedule']){
                $validate->handle([
                    'reason'=>[REQUIRED]
                ],'schedule');

                $id = intval($_POST['idSchedule']);

                if($validate->errors) {
                    Flash::set('resultUpdateSchedule', 'Erro ao cancelar agendamento!','message error');
                    return redirect("/admin/schedule");
                }
    
                $db = new Db();
                $db->connect();
                $schedule = new Schedule();
                $schedule = $schedule->getById($db,$id);
                $schedule->setStatus('cancelado');
                $schedule->setCancellationReason($validate->data['reason']);
                $schedule->setCancellationDescription($_POST['message']);
                
                if($schedule->update($db,$id)){
                    Flash::set('resultUpdateSchedule', 'Erro ao cancelar agendamento!','notification error');
                    return redirect("/admin/schedule");
                }
            }
    
         
        }
    }

    public function complete(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if($_POST['idSchedule']){
                $id = intval($_POST['idSchedule']);
                
                $db = new Db();
                $db->connect();
                $schedule = new Schedule();
                $schedule = $schedule->getById($db,$id);
                $schedule->setStatus('concluido');
                
                if($schedule->update($db,$id)){
                    Flash::set('resultUpdateSchedule', 'Erro ao concluir agendamento!','notification error');
                    return redirect("/admin/schedule");
                }
            }
    
        }
    }

    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        if(isset($args)){

            $db = new Db();
            $db->connect();
    
            $service = new Service();
            if($service->delete($db,intval($args[0]))){
                Flash::set('reultDeleteService', 'Erro ao excluir colaborador!','message sucess');
                return redirect("/admin/service");
            }

            Flash::set('reultDeleteService', 'Erro ao excluir colaborador!','message error');
            return redirect("/admin/service");
        }
    }
}

?>