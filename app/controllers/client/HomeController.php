<?php
namespace app\controllers\client;
use app\models\database\Db;
use app\models\Client;
use app\models\Company;
use app\models\Service;
use app\classes\Old;

class HomeController{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(){
        $this->view = 'home.php';
        $this->data = [
            'title'=>'Agenda facil',
        ];

        if(!isset($_SESSION['user']) || !isset($_SESSION['auth'])) {
            $this->view = 'indexNotLogin.php'; 
        }

      
        $db = new Db();
        $db->connect();
        // $db->setTable('company');

        $service = new Service("nome service","descrippppds","22.00","30",1,true);
        if($service->insert($db)){
            var_dump("registrou");
            die();
        }

        // // $firmas = $company->getById($db,4);
        // var_dump($firmas);
        // die();
        // $company->setName("funciona");
        // if($company->update($db,1)){
        //     var_dump("atualizou");
        //     die();
        // }

        // if($company->delete($db,1)){
        //     var_dump("deletou");
        //     die();
        // }

        // $clients = $client->getAll($db);
        // $email = "vitorhugojulieti@gmail.com";
        // $client = $client->getByEmail($db,$email);
        // $_SESSION['teste'] = $client;
        // $client->setAvatar('clwewqeqweqweqweqeitin');
        // $client->setName('testandoUPDAte');
        // $client->setCpf('333.333.333-00');
        // $client->setPhone('1899898978');
        // $client->setEmail('teste@gmail.xom');
        // $client->setPassword('cl12121212eitin');
        // $client->setRegistrationDate('12/12/12');
        // var_dump($clients);
        // var_dump($client->insert($db));
        // var_dump($client->update($db,10));
        // var_dump($client->emailIsUsed($db,$email));
        // var_dump($client->emailHasPassword($db,$email));
        // var_dump("estou na homeeeee");
        // var_dump($_SESSION['user']);
        // die();
        // $client = $client->getByEmail($db,$email);

        // $clientActual = new Client();
        // $clientActual->setAvatar("dasdasdas");
        // $clientActual->setName("name");
        // $clientActual->setEmail("email");
        // $clientActual->setRegistrationDate(date('d/m/y'));
        // $clientActual->setRegistrationComplete(0);
        // $clientActual->insert($db);
        // $_SESSION['user'] = $clientActual;
        // var_dump($_SESSION['user']);
        // die();

        // $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        // var_dump($code);
        // die();

    }
}

?>