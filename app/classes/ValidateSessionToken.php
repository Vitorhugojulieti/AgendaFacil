<?php

namespace app\classes;

use app\interfaces\ValidateInterface;
use app\models\database\Db;
use app\models\ValidateUsedFields;

class ValidateSessionToken implements ValidateInterface
{
    public function handle($field, $param,$table)
    {
        $token = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);

        if(!isset($_SESSION['token']) || $token !== $_SESSION['token']){
            return false;
        }

        return true;
    }
}

?>