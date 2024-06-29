<?php
namespace app\models;

class User{
    private string $id;
    private string $email;
    private string $password;
    private string $nvlUser;


    public function __construct($email,$password){
        $this->email = $email;
        $this->password = $password;
    }

    private function login(){

    }

    private function instantiateClassUser(){
        
    }
}



?>