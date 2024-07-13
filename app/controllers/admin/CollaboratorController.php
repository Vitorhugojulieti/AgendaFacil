<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Collaborator;
use app\classes\Flash;
use app\classes\ContactEmail;
use app\classes\ImageUpload;
use app\classes\Validate;
use app\classes\BlockNotAdmin;

class CollaboratorController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    // ok
    public function index(array $args){
        BlockNotAdmin::block($this,['index']);

        $db = new Db();
        $db->connect();

        $collaborators = new Collaborator();
        $collaborators = $collaborators->getAll($db);

        $this->view = 'admin/collaborators.php';
        $this->data = [
            'title'=>'Colaboradores | AgendaFacil',
            'collaborators'=>$collaborators,
        ];
    }

    public function edit(array $args){
        BlockNotAdmin::block($this,['edit']);

        $this->view = 'admin/editCollaborators.php';
        $this->data = [
            'title'=>'Editar colaborador | AgendaFacil',
            'id'=>intval($args[0]),
        ];

    }

    // ok
    public function show(array $args){
        BlockNotAdmin::block($this,['show']);

        if(isset($args)){
            $db = new Db();
            $db->connect();
            
            $collaborator = new Collaborator();
            $collaborator = $collaborator->getById($db,intval($args[0]));
        }

        $this->view = 'admin/showCollaborator.php';
        $this->data = [
            'title'=>'Visualizar colaborador | AgendaFacil',
            'collaborator'=>$collaborator,
        ];
    }

    //ok
    public function update(array $args){
        BlockNotAdmin::block($this,['update']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $db = new Db();
                $db->connect();
              
                $validate = new Validate();
                $collaborator = new Collaborator();
                $collaborator = $collaborator->getById($db,intval($_POST['id']));

                if($_FILES['avatar'] && $_FILES['avatar']['error'] == 0){
                    $validate->handle(['avatar'=>[IMAGE]],'collaborator');
                    $collaborator->setAvatar($validate->data['avatar']['success'] ? $validate->data['avatar']['link'] : AVATAR_DEFAULT);
                }

                if($_POST['name']){
                    $validate->handle(['name'=>[REQUIRED]],'collaborator');
                    $collaborator->setName($validate->data['name']);
                }

                if($_POST['cpf']){
                    $validate->handle(['cpf'=>[CPF]],'collaborator');
                    $collaborator->setCpf($validate->data['cpf']);
                }

                if($_POST['phone']){
                    $validate->handle(['phone'=>[REQUIRED]],'collaborator');
                    $collaborator->setPhone($validate->data['phone']);
                }

                if($_POST['email']){
                    $validate->handle(['email'=>[EMAIL]],'collaborator');
                    $collaborator->setEmail($validate->data['email']);
                }

                if($_POST['password']){
                    $validate->handle(['password'=>[PASSWORD]],'collaborator');
                    $collaborator->setPassword($validate->data['password']);
                }

                if($_POST['nivel']){
                    $validate->handle(['nivel'=>[REQUIRED]],'collaborator');
                    $collaborator->setNivel($validate->data['nivel']);
                }

                if($validate->errors) {
                    return redirect('/admin/collaborator/edit');
                }
                
                if($collaborator->update($db,$collaborator->getId())){
                    return redirect("/admin/collaborator");
                }

                Flash::set('reultUpdateCollaborator', 'Erro ao editar colaborador!');
                return redirect("/admin/collaborator/edit");
        }
        
     
    }

    //ok
    public function store(){
        BlockNotAdmin::block($this,['store']);

        $this->view = 'admin/cadCollaborators.php';
        $this->data = [
            'title'=>'Cadastrar colaborador | AgendaFacil',
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

                    $validate = new Validate();
                    $validate->handle([
                        'cpf'=>[CPF,REQUIRED],
                        'name'=>[REQUIRED],
                        'phone'=>[REQUIRED],
                        'nivel'=>[REQUIRED],
                        'email'=>[EMAIL,REQUIRED],
                        'password'=>[PASSWORD,REQUIRED],
                        'avatar'=>[IMAGE],
                    ],'collaborator');

                    if($validate->errors) {
                        return redirect('/admin/collaborator/store');
                    }
                  
                    $idCompany = $_SESSION['collaborator']->getIdCompany();

                    $db = new Db();
                    $db->connect();
                    $collaborator = new Collaborator($validate->data['avatar']['success'] ? $validate->data['avatar']['link'] : AVATAR_DEFAULT,$validate->data['name'],$validate->data['cpf'],$validate->data['phone'],$validate->data['email'],$validate->data['password'],$validate->data['nivel'],$idCompany,date('d/m/y'),0);
                
                    if($collaborator->insert($db)){
                        return redirect("/admin/collaborator/confirmEmail");
                    }

                    Flash::set('reultInsertCollaborator', 'Erro ao cadastrar colaborador!');
                    return redirect("/admin/collaborator/store");
                }
    }

    //ok
    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        if(isset($args)){

            $db = new Db();
            $db->connect();
    
            $collaborator = new Collaborator();
            if($collaborator->delete($db,intval($args[0]))){
                return redirect("/admin/collaborator");
            }

            Flash::set('reultDeleteCollaborator', 'Erro ao excluir colaborador!');
            return redirect("/admin/collaborator");
        }
    }

}

?>