<?php

namespace app\classes;

use app\interfaces\ValidateInterface;
use app\models\database\Db;
use app\models\ValidateUsedFields;

class ValidatePassword implements ValidateInterface
{
    public function handle($field, $param)
    {
        $password = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
        
        $db = new Db();
        $db->connect();
        $db->setTable('client');

        $validatorDb = new ValidateUsedFields($db);

        if($validatorDb->passwordIsUsed($password)){
            Flash::set($field, 'Essa senha já está em uso!');
            return false;
        }

        
        Old::set($field, $password);

        return $password;
    }
}

?>