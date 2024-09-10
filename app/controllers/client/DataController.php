<?php
namespace app\controllers\client;
use app\models\database\Db;
use app\models\Client;
use app\models\Company;
use app\models\Service;
use app\classes\Old;
use app\classes\Breadcrumb;


class DataController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        verifySession();
       
        $this->view = 'client/dataUser.php';
        $this->data = [
            'title'=>'Agenda facil',
            'user'=>$_SESSION['user'],
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get()
        ];

        if(!isset($_SESSION['user']) || !isset($_SESSION['auth'])) {
            $this->view = 'indexNotLogin.php'; 
        }



    }
}

?>