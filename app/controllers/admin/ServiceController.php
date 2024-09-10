<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Service;
use app\models\Images;
use app\classes\Flash;
use app\classes\Validate;
use app\classes\BlockNotAdmin;

class ServiceController implements ControllerInterface{
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
            // var_dump($service->getDuration()->format('H:i'));
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
    
            $service = new Service();
            $service = $service->getById($db,intval($args[0]));
        }

        if(isset($_SESSION['collaborator']) && $_SESSION['collaborator']->getNivel() === 'manager'){
            $this->view = 'admin/showService.php';
        }

        $this->view = 'client/showService.php';
        $this->data = [
            'title'=>'Visualizar serviço | AgendaFacil',
            'service'=>$service,
        ];
    }

    public function update(array $args){
        BlockNotAdmin::block($this,['update']);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();

            $validate = new Validate();
            $service = new Service();
            $service = $service->getById($db,intval($_POST['id']));

            if($_FILES['image1'] && $_FILES['image1']['error'] == 0){
                $validate->handle(['image1'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image1']['success'] ? $validate->data['image1']['link'] : AVATAR_DEFAULT);
            }

            if($_FILES['image2'] && $_FILES['image2']['error'] == 0){
                $validate->handle(['image2'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image2']['success'] ? $validate->data['image2']['link'] : AVATAR_DEFAULT);
            }

            if($_FILES['image3'] && $_FILES['image3']['error'] == 0){
                $validate->handle(['image3'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image3']['success'] ? $validate->data['image3']['link'] : AVATAR_DEFAULT);
            }

            if($_POST['name'] && $service->getName() !== $_POST['name']){
                $validate->handle(['name'=>[REQUIRED]],'service');
                $service->setName($validate->data['name']);
            }

            if($_POST['description'] && $service->getDescription() !== $_POST['description']){
                $validate->handle(['description'=>[REQUIRED]],'service');
                $service->setDescription($validate->data['description']);
            }

            if($_POST['duration'] && $service->getDuration() !== $_POST['duration']){
                $validate->handle(['duration'=>[TIME]],'service');
                $service->setDuration($validate->data['duration']);
            }

            if($_POST['price'] && $service->getPrice() !== $_POST['price']){
                $validate->handle(['price'=>[REQUIRED]],'service');
                $service->setPrice($validate->data['price']);
            }

            if($validate->errors) {
                return redirect('/admin/collaborator/edit');
            }
            
            if($service->update($db,$service->getId())){
                Flash::set('resultUpdateService', 'Serviço atualizado com sucesso!','notification sucess');
                return redirect("/admin/service");
            }

            Flash::set('resultUpdateService', 'Erro ao atualizar serviço!','notification error');
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
            $db = new Db();
            $db->connect();

            $validateData = $this->validateServiceData();
            $validateImages = $this->validateServiceImages();

            if(!$validateData || !$validateImages){
                return redirect("/admin/service/store");
            }

            $service = $this->registerService($db,$validateData,$_SESSION['collaborator']->getIdCompany());
            $images = $this->registerImages($db,$service,$_SESSION['collaborator']->getIdCompany(),$validateImages);   

            if(!$service || !$images){
                Flash::set('resultInsertService', 'Erro ao cadastrar serviço!','notification error');
                return redirect("/admin/service/store");
            }
            unset($_SESSION['old']);

            Flash::set('resultInsertService', 'Serviço cadastrado com sucesso!','notification sucess');
            return redirect("/admin/service");
        }
    }

    private function validateServiceData(){
        $validate = new Validate();
        $validate->handle([
            'name'=>[REQUIRED],
            'description'=>[REQUIRED],
            'price'=>[REQUIRED],
            'duration'=>[TIME],
        ],'services');
        if($validate->errors) {
            return false;
        }

        return $validate;
    }

    private function validateServiceImages(){
        $validateImages = new Validate();
        $validateImages->handle([
            'image1'=>[IMAGE],
            'image2'=>[IMAGE],
            'image3'=>[IMAGE],
        ],'services');

        if($validateImages->errors) {
            return false;
        }
        return $validateImages;
    }

    private function registerService(Db $db,$validate,$idCompany){
        var_dump($idCompany);

        $service = new Service(
            $validate->data['name'],
            $validate->data['description'],
            $validate->data['price'],
            $validate->data['duration'],
            $idCompany,true);

        $service->insert($db);
        $service = $service->getIdByName($db,$validate->data['name'],$idCompany);
        return $service ? $service : false;
    }

    private function registerImages($db,$idService,$idCompany,$validateImages){
        $imagesRegister = new Images();
        $dataImages = [
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image1']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image2']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
            ['typeImage'=>'serviceImage','link'=>$validateImages->data['image3']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService],
        ];

        return $imagesRegister->insert($db,$dataImages);
    }

    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        if(isset($args)){

            $db = new Db();
            $db->connect();
    
            $service = new Service();
            if($service->delete($db,intval($args[0]))){
                Flash::set('reultDeleteService', 'Serviço excluido com sucesso!','notification sucess');
                return redirect("/admin/service");
            }

            Flash::set('reultDeleteService', 'Erro ao excluir serviço!','notification error');
            return redirect("/admin/service");
        }
    }
}

?>