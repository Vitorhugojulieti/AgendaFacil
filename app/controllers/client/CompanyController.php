<?php
namespace app\controllers\client;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Company;
use app\models\Service;
use app\models\Evaluation;
use app\models\ServiceVoucher;
use app\models\Images;
use app\classes\Flash;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Maps;

class CompanyController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'masterAdmin.php';

    public function index(array $args){
   
    }

    public function edit(array $args){

    }

    public function show(array $args){
        if(isset($args)){
            $db = new Db();
            $db->connect();
    
            $company = new Company();
            $company = $company->getById($db,intval($args[0]));

            
            if(!$company){
                redirect('/');
            }

            //TODO criar opção para falha do mapa
            $map = new Maps();
            $map->setCep($company->getCep());
            $map->setNumber($company->getNumber());
            $map = $map->getMap();

            //get vouchers
            $vouchers = new ServiceVoucher();
            $vouchers = $vouchers->getByCompany($db,intval($args[0]));

            //get images
            $images = new Images();
            $images = $images->getByCompany($db,intval($args[0]));

            //get evaluations 
            $evaluations = new Evaluation();
            $evaluations = $evaluations->getByCompany($db,intval($args[0]));
        }

        $this->view = 'client/showCompany.php';
        $this->data = [
            'title'=>'Visualizar empresa | AgendaFacil',
            'company'=>$company,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'map'=>$map,
            'vouchers'=>$vouchers['vouchers'],
            'images'=>$images,
            'evaluations'=>$evaluations
        ];
    }
    public function update(array $args){
     
    }

    public function store(array $args){

    }

    public function destroy(array $args){
       
    }
}

?>