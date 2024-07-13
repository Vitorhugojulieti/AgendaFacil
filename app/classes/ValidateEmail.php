<?php

namespace app\classes;

use app\interfaces\ValidateInterface;
use app\models\database\Db;
use app\models\ValidateUsedFields;

class ValidateEmail implements ValidateInterface
{
    public function handle($field, $param,$table)
    {
        $email = filter_input(INPUT_POST, $field, FILTER_SANITIZE_EMAIL);
        
        $db = new Db();
        $db->connect();
        $db->setTable($table);

        $validatorDb = new ValidateUsedFields($db);
        if($validatorDb->emailIsUsed($email)){
            Flash::set($field, 'Esse email já está em uso!');
            return false;
        }

        
        Old::set($field, $email);

        return $email;
    }
}

?>