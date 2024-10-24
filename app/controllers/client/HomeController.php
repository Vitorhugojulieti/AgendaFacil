<?php
namespace app\controllers\client;
use app\models\database\Db;
use app\models\Client;
use app\models\Company;
use app\models\Service;
use app\classes\Old;
use app\classes\Cart;
use app\classes\Validate;
use app\classes\Breadcrumb;
use app\classes\Flash;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        Cart::delete();
        $db = new Db();
        $db->connect();
        $companys = new Company();
        // $companys = new Company();
        // $companys = $companys->getAll($db);
        if(isset($_SESSION['location'])){
            $companys = $companys->filterByLocationAndCategory($db,['city'=>$_SESSION['location']['localidade'],'state'=>$_SESSION['location']['uf']],'',1,10);
            
          
        }else{
            $companys = ["data"=>[]];
        }

        $this->view = 'home.php';
        $this->data = [
            'title'=>'Agenda facil',
            'companys'=>$companys['data'],
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get(),
            'navActive'=>'agenda'
        ];

        if(!isset($_SESSION['user']) || !isset($_SESSION['auth'])) {
            // $this->view = 'notFound.php';
            $this->view = 'indexNotLogin.php'; 
        }


    }

    public function filterByLocation(Db $db, String $city,String $uf){
        $companys = new Company();
        $companys = $companys->getByLocation($db,$city,$uf);
        return $companys;
    }
    
    // public function filterByLocation(){
        
    // }
    
    // public function filterByLocation(){
        
    // }

    public function setLocation(){
        // $cep = filter_input(INPUT_POST,$_POST['locationUser'], FILTER_SANITIZE_STRING);
        $cep = $_POST['locationUser'];
        $data = $this->searchAdressForCep($cep);

        if($data === null){
            Flash::set('resultLocation', 'Localização não encontrada!','notification error');  
            $_SESSION['location'] = null;  
            redirect('/');
        }else{
            $_SESSION['location'] = $data;
            redirect('/');
        }
    }
    
    public function  searchAdressForCep($cep) {
        $cep = preg_replace("/[^0-9]/", "", $cep);
        $url = "https://viacep.com.br/ws/$cep/json/";
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        $response = curl_exec($ch);
    
        curl_close($ch);
    
        $dados = json_decode($response, true);
    
        if (isset($dados['erro']) && $dados['erro'] === "true") {
            return null;
        }
    
        return $dados;
    }
}

?>