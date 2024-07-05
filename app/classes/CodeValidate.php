<?php
namespace app\classes;

class CodeValidate{
    public static function generate(){
        $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $_SESSION['codeConfirmEmail'] = $code;
        return $code;
    }

    public static function get(){
        if(isset($_SESSION['codeConfirmEmail'])){
            return $_SESSION['codeConfirmEmail'];
        }
    }
}


?>