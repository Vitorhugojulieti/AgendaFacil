<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Collaborator;
use app\models\ServiceVoucher;
use app\classes\Flash;
use app\classes\Old;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\CodeGenerator;

class ServiceVoucherController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    // ok
    public function index(array $args){
        BlockNotAdmin::block($this,['index']);

        $db = new Db();
        $db->connect();

        $vouchers = new ServiceVoucher();
        $vouchers = $vouchers->getAll($db);

        $this->view = 'admin/vouchers.php';
        $this->data = [
            'title'=>'Vales de serviços | AgendaFacil',
            'vouchers'=>$vouchers,
            'navActive'=>'Cupons',
        ];
    }

    public function edit(array $args){
        BlockNotAdmin::block($this,['edit']);

        if(isset($args)){
            $db = new Db();
            $db->connect();
            
            $voucher = new ServiceVoucher();
            $voucher = $voucher->getById($db,intval($args[0]));
            $servicesVoucher = $voucher->getServices($db);

            $services = new Service();
            $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        }

        $this->view = 'admin/registerAndUploadVoucher.php';
        $this->data = [
            'title'=>'Editar colaborador | AgendaFacil',
            'navActive'=>'Cupons',
            'legend'=>'Editar vale de serviços',
            'action'=>'/admin/serviceVoucher/update',
            'voucher'=>$voucher,
            'services'=>$services,
            'servicesVoucher'=>$servicesVoucher,
        ];

    }

    public function show(array $args){
        BlockNotAdmin::block($this,['show']);

        if(isset($args)){
            $db = new Db();
            $db->connect();
            
            $voucher = new ServiceVoucher();
            $voucher = $voucher->getById($db,intval($args[0]));
        }

        $this->view = 'admin/showCollaborator.php';
        $this->data = [
            'title'=>'Visualizar vale de serviços | AgendaFacil',
            'navActive'=>'Cupons',
            'voucher'=>$voucher,
        ];
    }

    //ok
    public function update(array $args){
        BlockNotAdmin::block($this,['update']);

        if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['idServiceVoucher']){
                $db = new Db();
                $db->connect();
              
                $validate = new Validate();
                $voucher = new Voucher();
                $voucher = $voucher->getById($db,intval($_POST['idServiceVoucher']));

                

                if($_POST['amount'] && $voucher->getAmount() !== $_POST['amount']){
                    $validate->handle(['amount'=>[REQUIRED]],'servicevoucher');
                    $voucher->setAmount()($validate->data['amount']);
                }

                if($_POST['dateOfIssue'] && $voucher->getDateOfIssue() !== $_POST['dateOfIssue']){
                    $validate->handle(['dateOfIssue'=>[REQUIRED]],'servicevoucher');
                    $voucher->setDateOfIssue()($validate->data['dateOfIssue']);
                }

                if($_POST['dateExpiration'] && $voucher->getDateExpiration() !== $_POST['dateExpiration']){
                    $validate->handle(['dateExpiration'=>[REQUIRED]],'servicevoucher');
                    $voucher->setDateExpiration()($validate->data['dateExpiration']);
                }

                if($validate->errors) {
                    return redirect('/admin/serviceVoucher/edit');
                }
                
                if($collaborator->update($db,$voucher->getId())){
                    Flash::set('resultUpdateVoucher', 'Vale de serviços editado com sucesso!','message sucess');
                    return redirect("/admin/serviceVoucher");
                }

                Flash::set('resultUpdateVoucher', 'Erro ao editar vale de serviços!','message error');
                return redirect("/admin/serviceVoucher/edit/".$voucher->getId());
        }
    }

    //ok
    public function store(){
        BlockNotAdmin::block($this,['store']);
        $db = new Db();
        $db->connect();

        $services = new Service();
        $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany());

        $this->view = 'admin/registerAndUploadVoucher.php';
        $this->data = [
            'title'=>'Cadastrar vale de serviços | AgendaFacil',
            'navActive'=>'Cupons',
            'legend'=>'Cadastrar novo vale de serviços',
            'action'=>'/admin/serviceVoucher/store',
            'services'=>$services,
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();

            $validateData = $this->validateVoucherData();
          
            if(!$validateData){
                return redirect("/admin/serviceVoucher/store");
            }

            $voucher = $this->registerVoucher($db,$validateData,$_SESSION['collaborator']->getIdCompany());
            if(!$voucher){
                Flash::set('resultInsertVoucher', 'Erro ao cadastrar vale de serviços!','message error');
                return redirect("/admin/serviceVoucher/store");
            }

            Flash::set('resultInsertVoucher', 'Vale de serviços cadastrado com sucesso!','message sucess');
            unset($_SESSION['old']);
            return redirect("/admin/serviceVoucher");
        }
    }

    private function validateVoucherData(){
        $validate = new Validate();
        $validate->handle([
            'amount'=>[REQUIRED],
            'dateOfIssue'=>[REQUIRED],
            'dateExpiration'=>[REQUIRED],
        ],'servicevoucher');
        if($validate->errors) {
            return false;
        }
        return $validate;
    }

    private function registerVoucher(Db $db,$validateData,$idCompany){
        $voucher = new ServiceVoucher(
            $idCompany,
            $validateData->data['nivel'],
            $validateData->data['amount'],
            $validateData->data['dateOfIssue'],
            $validateData->data['dateExpiration'],
            CodeGenerator::generateAlphanumericCode(12));
            return $voucher->insert($db);
    }

    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        if(isset($args)){

            $db = new Db();
            $db->connect();
    
            $voucher = new ServiceVoucher();
            if($voucher->delete($db,intval($args[0]))){
                Flash::set('reultDeleteVoucher', 'Vale de serviços excluido com sucesso!','message sucess');
                return redirect("/admin/serviceVoucher");
            }

            Flash::set('reultDeleteVoucher', 'Erro ao excluir vale de serviços!','message error');
            return redirect("/admin/serviceVoucher");
        }
    }

}

?>