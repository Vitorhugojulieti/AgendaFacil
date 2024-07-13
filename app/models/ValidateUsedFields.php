<?php
namespace app\models;

use app\models\database\Db;

class ValidateUsedFields{
    private Db $db;

    public function __construct(Db $db){
        $this->db = $db;
    }
    
    public function emailIsUsed($email){
        $emailFound = $this->db->query('email',"email = '{$email}'");
        if ($emailFound && !empty($emailFound[0]['email'])) {
            return true; 
        }

        return false;
    }

    public function cpfIsUsed($cpf){
        $cpfFound = $this->db->query('cpf',"cpf = '{$cpf}'");
        if(!$cpfFound){
            return false;
        }

        return true;
    }

    public function passwordIsUsed($password){
        $passwordFound = $this->db->query('password',"password = '{$password}'");
        if(!$passwordFound){
            return false;
        }

        return true;
    }

    public function cnpjIsUsed($cnpj){
        $cnpjFound = $this->db->query('cnpj',"cnpj ='{$cnpj}'");
        if(!$cnpjFound){
            return false;
        }

        return true;
    }
}


?>