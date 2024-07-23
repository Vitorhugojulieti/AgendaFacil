<?php

namespace app\classes;

use app\interfaces\ValidateInterface;
use app\classes\ImageUpload;

class ValidateImage implements ValidateInterface
{
    public function handle($field, $param,$table)
    {
        $imgUploader = new ImageUpload();
        $image = $_FILES[$field];

        if(isset($image) && $image['error'] == 0){
            $return = $imgUploader->upload($image);
            if($return['success']){
                return $return;
            }else{
                Flash::set($field, 'Imagem invalida!');
                Old::set($field, $image);   
                return false;
            }
        }
    }
}

?>