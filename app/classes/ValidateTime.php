<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class ValidateTime implements ValidateInterface
{
    public function handle($field, $param,$table)
    {
        $time = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);
        $date = \DateTime::createFromFormat('H:i', $time);
        $time =  $date ? $date->format('H:i') : '';

        if ($time === '') {
            Flash::set($time, 'O campo é obrigatório');
            return false;
        }

       

        Old::set($field, $time);
        return $time;
    }
}

?>