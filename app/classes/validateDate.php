<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class ValidateDate implements ValidateInterface
{
    public function handle($field, $param,$table)
    {
        $date = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);

        $dateTime = new \DateTime($date);

        // if ($day === '') {
        //     Flash::set($field, 'O campo é obrigatório');
        //     return false;
        // }

        Old::set($field, $date);
        return $dateTime;
    }
}

?>