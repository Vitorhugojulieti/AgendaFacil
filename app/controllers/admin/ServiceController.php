<?php
namespace app\controllers\admin;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Service;
use app\models\Schedule;
use app\models\Images;
use app\classes\Flash;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Breadcrumb;


class ServiceController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    private function sanitizeArgNumber($arg){
        $sanitizedAgument = filter_var($arg, FILTER_SANITIZE_NUMBER_INT);
        return filter_var($sanitizedAgument, FILTER_VALIDATE_INT) ? $sanitizedAgument : false;
    }

    public function index(array $args){
        BlockNotAdmin::block($this,['index']);
        $db = new Db();
        $db->connect();

        $services = new Service();
        $services = $services->getByCompany($db,$_SESSION['collaborator']->getIdCompany());
        //ordenando com inativos por ultimo
        usort($services, function($a, $b) {
            return $b->getVisible() - $a->getVisible();
        });
     
        $this->view = 'admin/services.php';
        $this->data = [
            'title'=>'Serviços | AgendaFacil',
            'services'=>$services,
            'navActive'=>'servicos',
            'breadcrumb'=>Breadcrumb::getForAdmin()
        ];
    }

    public function edit(array $args){
        BlockNotAdmin::block($this,['edit']);
        $idService = $this->sanitizeArgNumber($args[0]);
        if(isset($args) && $idService){
                $db = new Db();
                $db->connect();
                $service = new Service();
                $service = $service->getById($db,$idService);
        }else{
            Flash::set('resultUpdateService', 'Erro ao encontrar serviço!','notification error');
            return redirect("/admin/service");
        }

        $this->view = 'admin/registerAndUploadService.php';
        $this->data = [
            'title'=>'Editar serviço | AgendaFacil',
            'id'=>$idService,
            'navActive'=>'servicos',
            'legend'=>'Editar serviço',
            'buttonText'=>'Editar',
            'action'=>'/admin/service/update/'.$idService,
            'service'=>$service,
        ];

    }

    public function show(array $args){
        $idService = $this->sanitizeArgNumber($args[0]);
        if(isset($args) && $idService){
            $db = new Db();
            $db->connect();
            $service = new Service();
            $service = $service->getById($db,$idService);
        }else{
            Flash::set('resultUpdateService', 'Erro ao encontrar serviço!','notification error');
            return redirect("/admin/service");
        }

        $this->view = 'admin/showService.php';
        $this->data = [
            'title'=>'Visualizar serviço | AgendaFacil',
            'service'=>$service,
            'breadcrumb'=>Breadcrumb::getForAdmin()
        ];
    }

    public function getDataForDashboard(){
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        //TODO adicionar validacao de token 
        //TODO adicionar cabeçalhos para verificar origem da requisicao
        if(isset($_SESSION['collaborator']) && $_SESSION['auth']){
            if(isset($_GET['idService'])) {
                $idService = filter_var($_GET['idService'], FILTER_SANITIZE_NUMBER_INT);
                if(filter_var($idService, FILTER_VALIDATE_INT)){
                    $db = new Db();
                    $db->connect();
                    $schedules = new Schedule();
                    $months = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
                    $dataLine = ['schedules'=>[],'cancellations'=>[]];
                    $schedules = $schedules->getByService($db,$idService,$_SESSION['collaborator']->getIdCompany());
                    
                    if(count($schedules) != 0){
                        for($i=0; $i < 12; $i++){ 
                            $filteredSchedules = array_filter($schedules, function($schedule) use($i){
                                return $schedule->getDateSchedule()->format('m') == $i+1;
                            });
                            array_push($dataLine['schedules'],[$months[$i]=>count($filteredSchedules)]);

                            $filteredSchedules = array_filter($schedules, function($schedule) use($i){
                                return ($schedule->getDateSchedule()->format('m') == $i+1) && $schedule->getStatus() === 'cancelado';
                            });
                            array_push($dataLine['cancellations'],[$months[$i]=>count($filteredSchedules)]);
                        }
                    }else{
                        $dataLine = 0;
                    }
                
                    header('Content-Type: application/json');
                    echo json_encode($dataLine);
                    exit();
                }else {
                    header('HTTP/1.1 400 Bad Request');
                    echo json_encode(['error' => 'Parameter "service" type number is required']);
                }
            }else {
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Parameter "service" is required']);
            }    
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'User invalid!']);
        }
    }

    public function update(array $args){
        BlockNotAdmin::block($this,['update']);
        $idService = $this->sanitizeArgNumber($args[0]);
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $idService){
            $db = new Db();
            $db->connect();

            $validate = new Validate();
            $service = new Service();
            $service = $service->getById($db,$idService);
            $update = false;

            if($_POST['csrf_token']){
                $validate->handle(['csrf_token'=>[CSRF]],'company');
            }else{
                Flash::set('resultUpdateService', 'Erro ao editar serviço!','notification error');
                return redirect("/admin/service");
            }

         
         
            //TODO pesquisar como comparar as imagenss
            if($_FILES['image1']['name'] != "" && $_FILES['image1']['error'] == 0){
                $validate->handle(['image1'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image1']['success'] ? $validate->data['image1']['link'] : AVATAR_DEFAULT);
                $update = true;
            }
            

            if($_FILES['image2']['name'] != "" && $_FILES['image2']['error'] == 0){
                $validate->handle(['image2'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image2']['success'] ? $validate->data['image2']['link'] : AVATAR_DEFAULT);
                $update = true;
            }

            if($_FILES['image3']['name'] != "" && $_FILES['image3']['error'] == 0){
                $validate->handle(['image3'=>[IMAGE]],'service');
                $collaborator->setAvatar($validate->data['image3']['success'] ? $validate->data['image3']['link'] : AVATAR_DEFAULT);
                $update = true;
            }
          
            if(isset($_POST['name']) && ($service->getName() !== $_POST['name'])){
                $validate->handle(['name'=>[REQUIRED]],'service');
                $service->setName($validate->data['name']);
                $update = true;
            }

            if(isset($_POST['description']) && ($service->getDescription() !== $_POST['description'])){
                $validate->handle(['description'=>[REQUIRED]],'service');
                $service->setDescription($validate->data['description']);
                $update = true;
            }

            if(isset($_POST['duration']) && ($service->getDuration()->format('H:i') != $_POST['duration'])){
                $validate->handle(['duration'=>[TIME]],'service');
                $service->setDuration($validate->data['duration']);
                $update = true;
            }

            if(isset($_POST['price']) && ($service->getPrice() != $_POST['price'])){
                $validate->handle(['price'=>[REQUIRED]],'service');
                $service->setPrice($validate->data['price']);
                $update = true;
            }
                
            if(isset($_POST['visible']) && ($service->getVisible() != $_POST['visible'])){
                $validate->handle(['visible'=>[REQUIRED]],'services');
                $service->setVisible($validate->data['visible']);
                $update = true;
            }

            if($validate->errors) {
                Flash::set('resultUpdateService', 'Erro ao atualizar serviço!','notification error');
                return redirect('/admin/service/edit/'.$idService);
            }

            if(!$update){
                return redirect('/admin/service/'.$idService);
            }
                
            if($service->update($db,$service->getId())){
                unset($_SESSION['old']);
                Flash::set('resultUpdateService', 'Serviço atualizado com sucesso!','notification sucess');
                return redirect("/admin/service");
            }

            Flash::set('resultUpdateService', 'Erro ao atualizar serviço!','notification error');
            return redirect("/admin/service/edit");
           
        }else{
            Flash::set('resultUpdateService', 'Erro ao editar serviço!','notification error');
            return redirect("/admin/service");
        }
    }

    public function store(array $args){
        BlockNotAdmin::block($this,['store']);

        $this->view = 'admin/registerAndUploadService.php';
        $this->data = [
            'title'=>'Cadastrar serviço | AgendaFacil',
            'navActive'=>'servicos',
            'legend'=>'Cadastrar serviço',
            'buttonText'=>'Cadastrar',
            'action'=>'/admin/service/store',
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $db = new Db();
            $db->connect();

            $validateData = $this->validateServiceData();
            $validateImages = $this->validateServiceImages();
          
            if(!$validateData || !$validateImages){
                Flash::set('resultInsertService', 'Dados invalidos!','notification error');
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
            'visible'=>[REQUIRED],
            'name'=>[REQUIRED],
            'description'=>[REQUIRED],
            'price'=>[REQUIRED],
            'duration'=>[TIME],
            'csrf_token'=>[CSRF]
        ],'services');

        if($validate->errors) {
            return false;
        }
        return $validate;
    }

    private function validateServiceImages(){
        $validateImages = new Validate();

        if($_FILES['image1'] && $_FILES['image1']['error'] == 0){
            $validateImages->handle(['image1'=>[IMAGE]],'service');
        }

        if($_FILES['image2'] && $_FILES['image2']['error'] == 0){
            $validateImages->handle(['image2'=>[IMAGE]],'service');
        }

        if($_FILES['image3'] && $_FILES['image3']['error'] == 0){
            $validateImages->handle(['image3'=>[IMAGE]],'service');
        }
      
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
            $idCompany,
            $validate->data['visible'],
            new \DateTime());

        $service->insert($db);
        //TODO usar metodo para pegar ultimo registro
        $service = $service->getIdByName($db,$validate->data['name'],$idCompany);
        return $service ? $service : false;
    }

    private function registerImages($db,$idService,$idCompany,$validateImages){
        $imagesRegister = new Images();
        $dataImages = [];

        if(isset($validateImages->data['image1'])){
            array_push(['typeImage'=>'serviceImage','link'=>$validateImages->data['image1']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService]);
        }

        if(isset($validateImages->data['image2'])){
            array_push(['typeImage'=>'serviceImage','link'=>$validateImages->data['image2']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService]);
        }

        if(isset($validateImages->data['imag31'])){
            array_push(['typeImage'=>'serviceImage','link'=>$validateImages->data['image2']['link'],'Company_idCompany'=>$idCompany,'idService'=>$idService]);
        }

        return $imagesRegister->insert($db,$dataImages);
    }

    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        if(isset($args)){
            $idService = filter_var($args[0], FILTER_SANITIZE_NUMBER_INT);
            if(filter_var($idService, FILTER_VALIDATE_INT)){
                $db = new Db();
                $db->connect();
        
                $service = new Service();
                $service->setVisible(0);
                $service->setIdCompany($_SESSION['collaborator']->getIdCompany());
                if($service->update($db,$idService)){
                    Flash::set('reultDeleteService', 'Serviço inativado com sucesso!','notification sucess');
                    return redirect("/admin/service");
                }
                Flash::set('reultDeleteService', 'Erro ao inativar serviço!','notification error');
                return redirect("/admin/service");
            }
        }else{
            Flash::set('reultDeleteService', 'Erro ao inativar serviço!','notification error');
            return redirect("/admin/service");
        }
    }
}

?>