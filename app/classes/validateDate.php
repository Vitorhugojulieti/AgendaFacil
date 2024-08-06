<?php

namespace app\classes;

use app\interfaces\ValidateInterface;

class ValidateDate implements ValidateInterface
{
    public function handle($field, $param,$table)
    {
        $day = filter_input(INPUT_POST, $field, FILTER_SANITIZE_STRING);

        $dateTime = new \DateTime();
        $currentMonth = $dateTime->format('m'); 
        $currentYear = $dateTime->format('Y');

        $fullDate = new \DateTime("$currentYear-$currentMonth-$day");

        if ($day === '') {
            Flash::set($field, 'O campo é obrigatório');
            return false;
        }

        Old::set($field, $day);
        return $fullDate;
    }
}

?>