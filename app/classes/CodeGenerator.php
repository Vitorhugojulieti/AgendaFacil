<?php
namespace app\classes;

class CodeGenerator{
    public static function generate($digits){
        $code = str_pad(rand(0, 9999), $digits, '0', STR_PAD_LEFT);
        return $code;
    }

    public static function generateAlphanumericCode($length){
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }

    public static function get(){
        if(isset($_SESSION['codeConfirmEmail'])){
            return $_SESSION['codeConfirmEmail'];
        }
    }
}


?>