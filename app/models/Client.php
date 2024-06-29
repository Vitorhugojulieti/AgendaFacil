<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\DatabaseInterface;

class Client implements DatabaseInterface{
    private Db $db;
    private int $id;
    private string $avatar;
    private string $name;
    private string $cpf;
    private string $phone;
    private string $email;
    private string $password;
    private string $registrationDate;

    // public function __construct($id,$avatar,$name,$cpf,$phone,$email,$password,$registrationDate){
    //     $this->id = $id;
    //     $this->avatar = $avatar;
    //     $this->name = $name;
    //     $this->cpf = $cpf;
    //     $this->phone = $phone;
    //     $this->email = $email;
    //     $this->password = $password;
    //     $this->registrationDate = $registrationDate;

    //     //database
    //     $this->db = new Db();
    //     $this->db->connect();
    //     $this->db->setTable('clientes');
    // }
    
    
    public function __construct(){

        //database
        $this->db = new Db();
        $this->db->connect();
        $this->db->setTable('users');
    }

    public function getAll(){
        return $this->db->query("*");
        // $users = $this->db->query("*");
        // $newUsers =[];
        // foreach ($users as $user){
        //     $newClient = new Self();
        //     $newClient->setName($user['name']);
        //     array_push($newUsers,$newClient);
        // }
        // return $newUsers;
               
    }

    public function getById($id){

    }

    public function insert(){

    }

    public function update(){

    }

    public function delete(){

    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }
}




?>