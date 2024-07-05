<?php

namespace app\classes;

use app\interfaces\ValidateInterface;
use app\models\database\Db;
use app\models\ValidateUsedFields;

class ValidateCpf implements ValidateInterface
{
    public function handle($field, $param)
    {
        $cnpj = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
        
        $db = new Db();
        $db->connect();
        $db->setTable('company');

        $validatorDb = new ValidateUsedFields($db);

        if($validatorDb->cnpjIsUsed($cnpj)){
            Flash::set($field, 'Esse CNPJ já está em uso!');
            return false;
        }

        
        Old::set($field, $cnpj);

        return $cnpj;
    }
}

?>