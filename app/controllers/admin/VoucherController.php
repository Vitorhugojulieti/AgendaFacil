<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Service;
use app\models\ServiceVoucher;
use app\classes\Flash;
use app\classes\Old;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\CodeGenerator;
use app\classes\Breadcrumb;
use app\classes\Cart;

class VoucherController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    private function sanitizeArgNumber($arg){
        $sanitizedAgument = filter_var($arg, FILTER_SANITIZE_NUMBER_INT);
        return filter_var($sanitizedAgument, FILTER_VALIDATE_INT) ? $sanitizedAgument : false;
    }

    public function index(array $args){
        BlockNotAdmin::block($this,['index']);
        Cart::delete();

        $db = new Db();
        $db->connect();
        $vouchers = new ServiceVoucher();

        // get filter by url
        if(isset($args[0]) && isset($args[1])){
            $attribute = filter_var($args[0], FILTER_SANITIZE_STRING);
            $value = filter_var($args[1], FILTER_SANITIZE_STRING);
            if(!$attribute === false && (!$value === false || $value === '0')){
                $vouchers = $vouchers->getByAttribute($db,$_SESSION['collaborator']->getIdCompany(),$attribute,$value);
            }
        }else if(isset($args[0])){
            $page = filter_var($args[0], FILTER_SANITIZE_NUMBER_INT);
            if(filter_var($page, FILTER_VALIDATE_INT)){
                $vouchers = $vouchers->getByCompany($db,$_SESSION['collaborator']->getIdCompany(),$page,10);
                $pagination = $vouchers['pagination'];
                $vouchers = $vouchers['vouchers'];
            }
        }else{
            $vouchers = $vouchers->getByCompany($db,$_SESSION['collaborator']->getIdCompany(),1,10);
            $pagination = $vouchers['pagination'];
            $vouchers = $vouchers['vouchers'];
        }

        $this->view = 'admin/vouchers.php';
        $this->data = [
            'title'=>'Vales de serviços | AgendaFacil',
            'vouchers'=>$vouchers,
            'navActive'=>'cupons',
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'pagination'=>$pagination

        ];
    }
    
    public function edit(array $args){
        BlockNotAdmin::block($this,['edit']);

        $idVoucher = $this->sanitizeArgNumber($args[0]);
        if(isset($args) && $idVoucher){
            $db = new Db();
            $db->connect();
            $serviceManager = new Service();
            $voucher = new ServiceVoucher();
            $voucher = $voucher->getById($db,intval($args[0]));
            $services = new Service();
            $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
            $availableServices = [];

            if(Cart::get() == 0){
                Cart::initialize($voucher->getServices());
            }
    
            if(isset($args[1]) && $args[1] === 'delete'){
                Cart::remove(intval($args[2]));
                return redirect('/admin/voucher/edit/'.$args[0]);
            }
        
            if(isset($args[1]) && $args[1] === 'remove'){
                Cart::removeOne(intval($args[2]));
                return redirect('/admin/voucher/edit/'.$args[0]);
            }
        
            if(isset($args[1])){
                $service = $serviceManager->getById($db,intval($args[1]));
                if($service){
                    Cart::add($service);
                    Flash::set('resultAddService', 'Serviço adicionado ao carrinho!','notification sucess');
                    return redirect('/admin/voucher/edit/'.$args[0]);
                }
            }
    
            if(Cart::get() != 0){
                foreach ($services as $key => $service) {
                    $exist = false;
                    foreach (Cart::get() as $key => $serviceCart) {
                        if($serviceCart->getId() === $service->getId()){
                            $exist = true;
                        }
                    }
                    if(!$exist){
                        array_push($availableServices,$service);
                    }
                }
            }else{
                $availableServices = $services;
            }
                
        }else{
            Flash::set('resultUpdateVoucher', 'Erro ao acessar voucher!','notification error');
            return redirect('/admin/voucher/');
        }

        $this->view = 'admin/registerAndUploadVoucher.php';
        $this->data = [
            'title'=>'Editar colaborador | AgendaFacil',
            'navActive'=>'cupons',
            'legend'=>'Editar vale de serviços',
            'action'=>'/admin/voucher/update/'.$idVoucher,
            'voucher'=>$voucher,
            'services'=>isset($_SESSION['cart']) ? Cart::get() : [],
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'availableServices'=>$availableServices,
            'buttonText'=>'Editar',
            'amountCart'=>isset($_SESSION['cart']) ? Cart::getAmount() : 0.00,
            'hrefRemove'=> '/admin/voucher/edit/'.$idVoucher.'/remove/',
            'hrefDelete'=> '/admin/voucher/edit/'.$idVoucher.'/delete/',
            'hrefAdd'=> '/admin/voucher/edit/'.$idVoucher.'/',
        ];

    }
    
    public function show(array $args){
        BlockNotAdmin::block($this,['show']);

        $idVoucher = $this->sanitizeArgNumber($args[0]);
        if(isset($args) && $idVoucher){
            $db = new Db();
            $db->connect();
            $voucher = new ServiceVoucher();
            $voucher = $voucher->getById($db,$idVoucher);
        }else{
            Flash::set('resultUpdateVoucher', 'Erro ao acessar voucher!','notification error');
            return redirect('/admin/voucher/');
        }

        $this->view = 'admin/showVoucher.php';
        $this->data = [
            'title'=>'Visualizar vale de serviços | AgendaFacil',
            'navActive'=>'Cupons',
            'voucher'=>$voucher,
            'breadcrumb'=>Breadcrumb::getForAdmin()

        ];
    }

    private function updateServices(Db $db,array $servicesVoucher,int $idVoucher){
        $voucherManager = new ServiceVoucher();
        $voucherManager->setId($idVoucher);
        $idsCart = [];
        $idsVoucher = [];
        $update = false;
        $registerServices = false;
        $deleteServices = false;

        foreach (Cart::get() as $serviceCart) {
            array_push($idsCart,$serviceCart->getId());

            foreach ($servicesVoucher as $service) {
                array_push($idsVoucher,$service->getId());
                if($service->getId() === $serviceCart->getId()){
                    $service->setAmount($serviceCart->getAmount());
                }
            }
        }

        $adds = array_diff($idsCart,$idsVoucher);
        $removes = array_diff($idsVoucher,$idsCart);

        $objsAdd = array_filter(Cart::get(), function($service) use ($adds){
            return in_array($service->getId(),$adds);
        });

        $objsRemove = array_filter($servicesVoucher, function($service) use ($removes){
            return in_array($service->getId(),$removes);
        });

        if(count($objsAdd) > 0){
            $update = true;
            $registerServices = $voucherManager->insertServices($db,$objsAdd);
        }

        if(count($objsRemove) > 0){
            $update = true;
            foreach ($objsRemove as $service) {
                $deleteServices = $voucherManager->removeService($db,$service->getId());
            }
        }

        if(!$voucherManager->updateAmountForServices($db,$servicesVoucher)){
            $update = false;
        }else{
            $update = true;
        }

        if($update && ($registerServices || $deleteServices)){
            return true;
        }

        return false;
    }

    public function update(array $args){
        BlockNotAdmin::block($this,['update']);

        $idVoucher = $this->sanitizeArgNumber($args[0]);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $idVoucher){
            $db = new Db();
            $db->connect();
            $validate = new Validate();
            $voucher = new ServiceVoucher();
            $voucher = $voucher->getById($db,$idVoucher);
            $updateServices = $this->updateServices($db,$voucher->getServices(),$idVoucher);
            $update = false;

            if($_POST['csrf_token']){
                $validate->handle(['csrf_token'=>[CSRF]],'company');
            }else{
                Flash::set('resultUpdateVoucher', 'Erro ao editar voucher!','notification error');
                return redirect("/admin/service");
            }

            if(isset($_POST['name']) && ($voucher->getName() !== $_POST['name'])){
                $validate->handle(['name'=>[REQUIRED]],'servicevoucher');
                $voucher->setName($validate->data['name']);
                $update = true;
            }
              
            if(isset($_POST['discount']) && ($voucher->getDiscount() != $_POST['discount'])){
                $validate->handle(['discount'=>[REQUIRED]],'servicevoucher');
                $voucher->setDiscount($validate->data['discount']);
                $validate->data['discount'] != 0 ? $voucher->setAmount(Cart::getAmount() - (Cart::getAmount() * ($validate->data['discount']/100))) : $voucher->setAmount(Cart::getAmount());
                $update = true;
            }
                
            if(isset($_POST['duration']) && ($voucher->getDuration() != $_POST['duration'])){
                $validate->handle(['duration'=>[REQUIRED]],'servicevoucher');
                $voucher->setDuration($validate->data['duration']);
                $update = true;
            }
             
            if(isset($_POST['active']) && ($voucher->getActive() != $_POST['active'])){
                $validate->handle(['active'=>[REQUIRED]],'servicevoucher');
                $voucher->setActive($validate->data['active']);
                $update = true;
            }
             
            if(isset($_POST['description']) && ($voucher->getDescription() !== $_POST['description'])){
                $validate->handle(['description'=>[REQUIRED]],'servicevoucher');
                $voucher->setDescription($validate->data['description']);
                $update = true;
            }
                
            if($update === false && $updateServices === false){
                return redirect('/admin/voucher/');
            }

            if($validate->errors) {
                Flash::set('resultUpdateVoucher', 'Erro ao editar vale de serviços!','notification error');
                return redirect('/admin/voucher/edit/'.$idVoucher);
            }
    
            if($voucher->update($db,$voucher->getId())){
                Flash::set('resultUpdateVoucher', 'Vale de serviços editado com sucesso!','notification sucess');
                return redirect("/admin/voucher");
            }

            Flash::set('resultUpdateVoucher', 'Erro ao editar vale de serviços!','notification error');
            return redirect("/admin/voucher/edit/".$idVoucher);
        }else{
            Flash::set('resultUpdateVoucher', 'Erro ao editar vale de serviços!','notification error');
            return redirect('/admin/voucher/');
        }
    }

    public function store(array $args){
        BlockNotAdmin::block($this,['store']);

        $db = new Db();
        $db->connect();
        $serviceManager = new Service();
        $services = $serviceManager->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        $availableServices = [];

        if(Cart::get() != 0){
            foreach ($services as $key => $service) {
                $exist = false;
                foreach (Cart::get() as $key => $serviceCart) {
                    if($serviceCart->getId() === $service->getId()){
                        $exist = true;
                    }
                }
                if(!$exist){
                    array_push($availableServices,$service);
                }
            }
       }else{
            $availableServices = $services;
       }

        if(isset($args[0]) && $args[0] === 'delete'){
            $idVoucher = filter_var($args[1], FILTER_SANITIZE_NUMBER_INT);
            if(filter_var($idVoucher, FILTER_VALIDATE_INT)){
                Cart::remove($idVoucher);
                return redirect('/admin/voucher/store');
            }
        }

        if(isset($args[0]) && $args[0] === 'remove'){
            $idVoucher = filter_var($args[1], FILTER_SANITIZE_NUMBER_INT);
            if(filter_var($idVoucher, FILTER_VALIDATE_INT)){
                Cart::removeOne($idVoucher);
                return redirect('/admin/voucher/store');
            }
        }

        if(isset($args[0])){
            $idVoucher = filter_var($args[0], FILTER_SANITIZE_NUMBER_INT);
            if(filter_var($idVoucher, FILTER_VALIDATE_INT)){
                $service = $serviceManager->getById($db,$idVoucher);
                if($service){
                    Cart::add($service);
                    Flash::set('resultAddService', 'Serviço adicionado ao carrinho!','notification sucess');
                    return redirect('/admin/voucher/store');
                }
            }
        }
        
        $this->view = 'admin/registerAndUploadVoucher.php';
        $this->data = [
            'title'=>'Cadastrar vale de serviços | AgendaFacil',
            'navActive'=>'Cupons',
            'legend'=>'Cadastrar novo vale de serviços',
            'action'=>'/admin/voucher/store',
            'breadcrumb'=>Breadcrumb::getForAdmin(),
            'services'=> isset($_SESSION['cart']) ? Cart::get() : [],
            'availableServices'=>$availableServices,
            'buttonText'=>'Cadastrar',
            'amountCart'=>isset($_SESSION['cart']) ? Cart::getAmount() : 0.00,
            'hrefRemove'=> '/admin/voucher/store/remove/',
            'hrefDelete'=> '/admin/voucher/store/delete/',
            'hrefAdd'=> '/admin/voucher/store/'
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();

            $validateData = $this->validateVoucherData();
            if(!$validateData){
                Flash::set('resultInsertVoucher', 'Dados invalidos!','notification error');
                return redirect("/admin/voucher/store");
            }
            
            $dateExpiration = $this->calculateDateExpiration(intval($validateData->data['duration']));
            $amount = Cart::getAmount();
            $discount = filter_var($_POST['discount'], FILTER_SANITIZE_NUMBER_INT);
            $active = filter_var($_POST['active'], FILTER_SANITIZE_NUMBER_INT);
            $idVoucher = $this->registerVoucher($db,$validateData,$_SESSION['collaborator']->getIdCompany(),$dateExpiration,$amount,$active,$discount);
            $servicesRegister = $this->registerServices($db,$idVoucher);
          
            if($idVoucher && $servicesRegister){
                Flash::set('resultInsertVoucher', 'Vale de serviços cadastrado com sucesso!','notification sucess');
                Cart::delete();
                unset($_SESSION['old']);
                return redirect("/admin/voucher");
            }

            Flash::set('resultInsertVoucher', 'Erro ao cadastrar vale de serviços!','notification error');
            return redirect("/admin/voucher/store");
        }
    }

    private function calculateDateExpiration(int $option){
        $now = new \DateTime();
        switch ($option) {
            case 1:
                return $now->modify('+7 days');
                break;
            
            case 10:
                return $now->modify('+1 months');
                break;

            case 60:
                return $now->modify('+6 months');
                break;

            case 100:
                return $now->modify('+1 year');
                break;

            default:
                return $now;
                break;
        }

    }

    private function validateVoucherData(){
        $validate = new Validate();
        $validate->handle([
            'name'=>[REQUIRED],
            'description'=>[REQUIRED],
            'duration'=>[REQUIRED],
            'csrf_token'=>[CSRF]
        ],'servicevoucher');

        if($validate->errors) {
            return false;
        }
        return $validate;
    }

    private function registerVoucher(Db $db,$validateData,$idCompany,$dateExpiration,$amount,$active,$discount){
        $voucher = new ServiceVoucher(
            $idCompany,
            $validateData->data['name'],
            $amount,
            $dateExpiration,
            CodeGenerator::generateAlphanumericCode(12),
            $active,
            $validateData->data['description'],
            new \DateTime(),
            intval($validateData->data['duration']),
            $discount);

            if($voucher->insert($db)){
                return $voucher->getLastRecord($db);
            }
            return false;
    }

    private function registerServices(Db $db,int $idVoucher){
        $voucher = new ServiceVoucher();
        $voucher->setId($idVoucher);
        if($voucher->insertServices($db,Cart::get(),$idVoucher)){
            return true;
        }
        return false;
    }

    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        $idVoucher = $this->sanitizeArgNumber($args[0]);
        if(isset($args) && $idVoucher){
            $db = new Db();
            $db->connect();
        
            $voucher = new ServiceVoucher();
            $voucher->setActive(0);
            $voucher->setIdCompany($_SESSION['collaborator']->getIdCompany());
            if($voucher->update($db,$idVoucher)){
                Flash::set('reultInativeVoucher', 'Vale de serviços inativado com sucesso!','notification sucess');
                return redirect("/admin/voucher");
            }
    
            Flash::set('reultInativeVoucher', 'Erro ao inativar vale de serviços!','notification error');
            return redirect("/admin/voucher");
        }else{
            Flash::set('resultUpdateVoucher', 'Erro ao acessar voucher!','notification error');
            return redirect('/admin/voucher/');
        }
    }

}

?>