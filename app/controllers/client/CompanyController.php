<?php
namespace app\controllers\client;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Company;
use app\models\Service;
use app\models\Images;
use app\classes\Flash;
use app\classes\Validate;
use app\classes\BlockNotAdmin;

class CompanyController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    public function index(array $args){
        $db = new Db();
        $db->connect();

        $services = new Service();
        $services = $services->getAll($db);

        if(isset($_SESSION['collaborator']) && $_SESSION['collaborator']->getNivel() === 'manager'){
            $this->view = 'admin/services.php';
        }
        $this->view = 'admin/services.php';

        // $this->view = 'client/services.php';
        $this->data = [
            'title'=>'Serviços | AgendaFacil',
            'services'=>$services,
            'navActive'=>'servicos',

        ];
    }

    public function edit(array $args){
        BlockNotAdmin::block($this,['edit']);
        if(isset($args)){
            $db = new Db();
            $db->connect();
    
            $service = new Service();
            $service = $service->getById($db,intval($args[0]));
        }

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
    
            $company = new Company();
            $company = $company->getById($db,intval($args[0]));
        }

        $this->view = 'client/showCompany.php';
        $this->data = [
            'title'=>'Visualizar empresa | AgendaFacil',
            'company'=>$company,
        ];
    }
    public function update(array $args){
        BlockNotAdmin::block($this,['update']);
        //adcicionar validate 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();
          
            $service = new Service();
            $service = $service->getById($db,intval($_POST['id']));

            // if($_FILES['imageService'] && $_FILES['imageService']['error'] == 0){
            //     $validate = new Validate();
            //     $validate->handle(['imageService'=>[IMAGE]],'collaborator');
            //     $collaborator->setAvatar($validate->data['avatar']['success'] ? $validate->data['avatar']['link'] : AVATAR_DEFAULT);
            // }

            if($_POST['name']){
                $validate = new Validate();
                $validate->handle(['name'=>[REQUIRED]],'service');
                $service->setName($validate->data['name']);
            }

            if($_POST['description']){
                $validate->handle(['description'=>[REQUIRED]],'service');
                $service->setDescription($validate->data['description']);
            }

            if($_POST['duration']){
                $validate->handle(['duration'=>[TIME]],'service');
                $service->setDuration($validate->data['duration']);
            }

            if($_POST['price']){
                $validate->handle(['price'=>[REQUIRED]],'service');
                $service->setPrice($validate->data['price']);
            }

            // if($_POST['visible']){
            //     $service->setVisible($_POST['visible']);
            // }


            if($validate->errors) {
                return redirect('/admin/collaborator/edit');
            }
            
            if($service->update($db,$service->getId())){
                Flash::set('resultUpdateService', 'Erro ao editar serviço!','message sucess');
                return redirect("/admin/services");
            }

            Flash::set('resultUpdateService', 'Erro ao editar serviço!','message error');
            return redirect("/admin/service/edit");
        }
        
     
    }

    public function store(array $args){
        BlockNotAdmin::block($this,['store']);

        $this->view = 'admin/registerAndUploadService.php';
        $this->data = [
            'title'=>'Cadastrar serviço | AgendaFacil',
            'navActive'=>'servicos',
            'legend'=>'Cadastrar serviço',
            'action'=>'/admin/service/store',
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $validate = new Validate();
            $validate->handle([
                'name'=>[REQUIRED],
                'description'=>[REQUIRED],
                'price'=>[REQUIRED],
                'duration'=>[TIME],
            ],'services');

            $validateImages = new Validate();
            $validateImages->handle([
                'image1'=>[IMAGE],
                'image2'=>[IMAGE],
                'image3'=>[IMAGE],
            ],'services');

            if($validate->errors || $validateImages->errors) {
                return redirect('/admin/service/store');
            }

            $idCompany = $_SESSION['collaborator']->getIdCompany();

            $db = new Db();
            $db->connect();

            $imagesRegister = new Images();
            $service = new Service($validate->data['name'],$validate->data['description'],$validate->data['price'],(float)$validate->data['duration'],true,$idCompany);

            $registration = $service->insert($db);

            $idService = $service->getIdByName($db,$validate->data['name'],$idCompany);
            $dataImages = [
                ['typeImage'=>'serviceImage','link'=>$validateImages->data['image1']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
                ['typeImage'=>'serviceImage','link'=>$validateImages->data['image2']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
                ['typeImage'=>'serviceImage','link'=>$validateImages->data['image3']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
            ];

            if($imagesRegister->insert($db,$dataImages) && $registration){
                Flash::set('resultInsertService', 'Serviço cadastrado com sucesso!','sucess');
                return redirect("/admin/service");
            }

            Flash::set('resultInsertService', 'Erro ao cadastrar serviço!','error');
            return redirect("/admin/service/store");
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