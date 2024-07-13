<?php

namespace app\classes;

use app\interfaces\ValidateInterface;
use app\models\database\Db;
use app\models\ValidateUsedFields;

class ValidateCpf implements ValidateInterface
{
    public function handle($field, $param,$table){
        $cpf = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
        
        $db = new Db();
        $db->connect();
        $db->setTable($table);

        $validatorDb = new ValidateUsedFields($db);

        if($validatorDb->cpfIsUsed($cpf)){
            Flash::set($field, 'Esse CPF já está em uso!');
            return false;
        }

        
        Old::set($field, $cpf);

        return $cpf;
    }
}

?>