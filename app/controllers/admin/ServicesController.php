<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Service;
use app\classes\Flash;
use app\classes\Validate;
use app\classes\BlockNotAdmin;

class ServicesController implements ControllerInterface{
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

        $this->view = 'client/services.php';
        $this->data = [
            'title'=>'Serviços | AgendaFacil',
            'servicos'=>$services,
        ];
    }

    public function edit(array $args){
        BlockNotAdmin::block($this,['edit']);

        $this->view = 'admin/editCollaborators.php';
        $this->view = 'home.php';
        $this->data = [
            'title'=>'Editar serviço | AgendaFacil',
            'id'=>intval($args[0]),
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
                $validate->handle(['duration'=>[REQUIRED]],'service');
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
                return redirect("/admin/services");
            }

            Flash::set('reultUpdateService', 'Erro ao editar serviço!');
            return redirect("/admin/service/edit");
        }
        
     
    }

    public function store(){
        BlockNotAdmin::block($this,['store']);

        $this->view = 'admin/cadCollaborators.php';
        $this->data = [
            'title'=>'Cadastrar colaborador | AgendaFacil',
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $validate = new Validate();
            $validate->handle([
                'name'=>[REQUIRED],
                'description'=>[REQUIRED],
                'price'=>[REQUIRED],
                'duration'=>[REQUIRED],
                // 'visible'=>[REQUIRED],
                // 'imageService'=>[IMAGE],
            ],'services');

            if($validate->errors) {
                return redirect('/admin/collaborator/store');
            }

            $idCompany = $_SESSION['collaborator']->getIdCompany();

            $db = new Db();
            $db->connect();
            //$validate->data['imageService']['success'] ? $validate->data['avatar']['link'] : AVATAR_DEFAULT
            $service = new Service($validate->data['name'],$validate->data['description'],$validate->data['price'],$validate->data['duration'],true,$idCompany);
                    

            if($service->insert($db)){
                return redirect("/admin/services");
            }

            Flash::set('reultInsertService', 'Erro ao cadastrar serviço!');
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
                return redirect("/admin/services");
            }

            Flash::set('reultDeleteCollaborator', 'Erro ao excluir colaborador!');
            return redirect("/admin/services");
        }
    }
}

?>