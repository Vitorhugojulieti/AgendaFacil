<?php

namespace app\classes;
use app\models\User;
use app\classes\Db;

class Authenticate{
    public function authGoogle($data){
        $db = new Db();
        $db->connect();
        $db->setTable('users');

        $client = new Client();
        $client = $client->getByEmail($data->email);
    

        //registration
        if($client){
            $clientActual = new Client();
            $clientActual->setAvatar($data->picture);
            $clientActual->setName($data->givenName." ".$data->familyName);
            $clientActual->setEmail($data->email);
            $clientActual->setRegistrationDate(date('d/m/y'));
            if($clientActual->insert($db)){
                $_SESSION['user'] = $clientActual;
                $_SESSION['auth'] = true;
                header("location:/");
            }
        }

        $_SESSION['user'] = $clientActual;
        $_SESSION['auth'] = true;
        header("location:/");
    }
}

?>