<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Collaborator;
use app\models\Company;
use app\models\ServiceVoucher;
use app\models\Service;
use app\classes\Flash;
use app\classes\Old;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\CodeGenerator;
use app\classes\Breadcrumb;


class ReportController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    // ok
    public function index(array $args){
        BlockNotAdmin::block($this,['index']);

        $db = new Db();
        $db->connect();

        // $vouchers = new ServiceVoucher();
        // $vouchers = $vouchers->getAll($db);

        $services = new Service();
        $services = $services->getAll($db);

        $company = new Company();
        $company = $company->getById($db,$_SESSION['collaborator']->getIdCompany());
        $activeCompany = $company->getRegistrationComplete() == 1 ? 'Empresa ativa' : 'Empresa inativa'; 

        $this->view = 'admin/reports.php';
        $this->data = [
            'title'=>'Relatorios | AgendaFacil',
            'navActive'=>'relatorios',
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'services'=>$services,
            'activeCompany'=>$activeCompany


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
    public function store(array $args){
    
    }

   


    public function destroy(array $args){
       
    }

}

?>