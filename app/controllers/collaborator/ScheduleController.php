<?php
namespace app\controllers\collaborator;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Schedule;
use app\models\ScheduleOrder;
use app\models\Service;
use app\models\Company;
use app\models\Collaborator;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Flash;
use app\classes\Cart;
use app\classes\Breadcrumb;
use app\classes\MercadoPagoIntegration;
use Ramsey\Uuid\Uuid;


class ScheduleController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    private function sanitizeArgNumber($number){
        $sanitizedAgument = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
        return intval($sanitizedAgument);
    }

    public function index(array $args){
        $db = new Db();
        $db->connect();
       

        $this->view = 'client/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            // 'schedules'=>$schedules,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get()
        ];
    }

    public function show(array $args){
        $db = new Db();
        $db->connect();
        $schedule = new Schedule();
        $schedule = $schedule->getById($db,intval($args[0]));
        $orders = new ScheduleOrder();
        $orders = $orders->getBySchedule($db,intval($args[0]));

        $this->view = 'client/showSchedule.php';
        $this->data = [
            'title'=>'Detalhes agendamento | AgendaFacil',
            'schedule'=>$schedule,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get(),
            'orders'=>$orders
        ];
    }

 
    public function getSchedules(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        if (isset($_GET['day']) && isset($_GET['month']) ) {
            // if (isset($_GET['day']) && isset($_GET['month']) && isset($_SESSION['user']) && isset($_SESSION['auth'])) {
            // returnin ['schedules'=> $schedulesDayForMonth];
            $day = intval($_GET['day']);
            $month = intval($_GET['month']);

            $date = new \DateTime();
            $date->setDate(date('Y'), $month, $day);
            $date->setTime(0, 0, 0);

            $db = new Db();
            $db->connect();

            $schedules = new Schedule();
            // $schedules = $schedules->getByClient($db,1);
            $schedules = $schedules->getByCollaborator($db,$_SESSION['collaborator']->getId());
            
            $schedules = array_filter($schedules, fn($schedule) => $schedule->getDateSchedule() == $date);

            header('Content-Type: application/json');
            echo json_encode($schedules);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "day" and "month" is required']);
        }
    }


    public function cancelSchedule(array $args){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $validate = new Validate();
            if($_POST['message']){
                $validate->handle([
                    'message'=>[REQUIRED]
                ],'schedule');
            }
    
            if($validate->errors) {
                Flash::set('reultDeleteService', 'Erro ao excluir colaborador!','message sucess');
                return redirect("/schedule");
            }
            $db = new Db();
            $db->connect();
            $schedule = new Schedule();
            $schedule->getCancellationReason($validateData->data['message']);
            
            if($schedule->update($db,$args[0])){
                Flash::set('reultDeleteService', 'Erro ao excluir colaborador!','message sucess');
                return redirect("/schedule");
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