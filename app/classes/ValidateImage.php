<?php

namespace app\classes;

use app\interfaces\ValidateInterface;
use app\models\database\Db;
use app\models\ValidateUsedFields;

class ValidateImage implements ValidateInterface
{
    public function handle($field, $param,$table)
    {
        $image = $_FILES[$field];

        if(isset($image) && $image['error'] == 0){
            $imgUpload = new ImageUpload();
            $return = $imgUpload->upload($image);

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