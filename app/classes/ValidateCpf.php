<?php

namespace app\classes;

use app\interfaces\ValidateInterface;
use app\models\database\Db;
use app\models\Client;

class ValidateCpf implements ValidateInterface
{
    public function handle($field, $param)
    {
        $cpf = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
        
        $db = new Db();
        $db->connect();
        $db->setTable('users');

        $client = new Client();

        if($client->cpfIsUsed($db,$cpf)){
            Flash::set($field, 'Esse CPF já está em uso!');
            return false;
        }

        
        Old::set($field, $cpf);

        return $cpf;
    }
}

?>