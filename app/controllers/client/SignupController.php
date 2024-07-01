<?php
namespace app\controllers\client;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Client;
use app\classes\Validate;

class SignupController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        $this->view = 'client/formCadClient.php';
        $this->data = [
            'title'=>'Cadastre-se | AgendaFacil',
        ];
    }

    public function edit(array $args){

    }

    public function show(array $args){

    }

    public function update(array $args){

    }

    public function store(){
        $db = new Db();
        $db->connect();
        $db->setTable('users');

        $validate = new Validate();
        $validate->handle([
            'name'=>[REQUIRED],
            'phone'=>[REQUIRED],
            'email'=>[EMAIL],
            'cpf'=>[CPF,REQUIRED],
            'password'=>[PASSWORD,REQUIRED]
        ]);

        if($validate->errors) {
            return redirect('/signup');
        }

        //registration
        $registrationDate = date('d/m/y');
        $client = new Client("",$validate->data['name'],$validate->data['cpf'],$validate->data['phone'],$validate->data['email'],$validate->data['password'],$registrationDate);
        if($client->insert($db)){
            var_dump("cadastrado");
        }
    }

    public function destroy(array $args){

    }
}

?>