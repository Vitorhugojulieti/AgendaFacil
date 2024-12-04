<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Collaborator;
use app\models\Company;
use app\models\Schedule;
use app\models\Receipt;
use app\models\Service;
use app\classes\Flash;
use app\classes\Old;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Reports;


class ReportController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    // ok
    public function index(array $args){

        $db = new Db();
        $db->connect();

        $schedules = new Schedule();
        $schedules = $schedules->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
       
        // $reportsPdf = new Reports();
        // $reportsPdf->generatePDF($schedules,'11/10/2024','12/12/2024');
        $collaborators = new Collaborator();
        $collaborators = $collaborators->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        $collaborators = $collaborators['collaborators'];

        $services = new Service();
        $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        $services = $services['services'];

        $this->view = 'admin/reports.php';
        $this->data = [
            'title'=>'Relatorios | AgendaFacil',
            'navActive'=>'relatorios',
            'services'=>$services,
            'collaborators'=>$collaborators
        ];

     
    }

    public function edit(array $args){
      

    }

    public function show(array $args){

    }

    //ok
    public function update(array $args){
        
    }

    //ok
    public function store(array $args)
    {

        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = new Db();
            $db->connect();
    
            $filter = $_POST['filter'] ?? null;
            $status = $_POST['status'] ?? null;
            $startDate = $_POST['startDate'] ?? null;
            $endDate = $_POST['endDate'] ?? null;
            $service = $_POST['service'] ?? null;
            $collaborator = $_POST['collaborator'] ?? null;
    
            // Salvar filtros na sessão para uso no endpoint de geração de PDF
            $_SESSION['report_filters'] = compact('filter', 'status', 'startDate', 'endDate', 'service', 'collaborator');
    
            // Redirecionar ou retornar um link para abrir o PDF
            echo json_encode(['pdf_url' => '/admin/report/generateReport']);
        }
    }
    
    //TODO finalizar relatorios
    public function generateReport(){
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        if (!isset($_SESSION['report_filters'])) {
            http_response_code(400);
            echo "Filtros de relatório não encontrados.";
            return;
        }
    
        $filters = $_SESSION['report_filters'];
        $db = new Db();
        $db->connect();
        $reportsPdf = new Reports();
    
        // Recuperar filtros
        $filter = $filters['filter'];
        $status = $filters['status'];
        $startDate = $filters['startDate'];
        $endDate = $filters['endDate'];
        $service = $filters['service'];
        $collaborator = $filters['collaborator'];
    
        // Gerar relatórios conforme o tipo
        if ($filter === "pagamentos" || $filter === "recebimentos") {
            $receipts = new Receipt();
            $receipts = $receipts->getReceiptsByFilters(
                $db,
                $_SESSION['collaborator']->getIdCompany(),
                $startDate,
                $endDate,
                ($filter === "pagamentos") ? intval($collaborator) : 0
            );
            $reportsPdf->generatePDF($filter, $receipts, $startDate, $endDate);
        } elseif ($filter === "agendamentos") {
            $schedules = new Schedule();
            $schedules = $schedules->getSchedulesByFilters(
                $db,
                $_SESSION['collaborator']->getIdCompany(),
                $status,
                $startDate,
                $endDate,
                1,
                10000
            );
            $schedules = $schedules['schedules'];
            $reportsPdf->generatePDF('schedule', $schedules, $startDate, $endDate);
        }
    }
    
   


    public function destroy(array $args){
       
    }

}

?>