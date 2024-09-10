<?php

namespace app\classes;
use app\models\Client;
use app\models\database\Db;

class Authenticate{
    public function authGoogle($data){
        $db = new Db();
        $db->connect();

        $client = new Client();
        $client = $client->getByEmail($db,$data->email);

        //registration
        if($client === false){
            $clientActual = new Client();
            $clientActual->setAvatar($data->picture);
            $clientActual->setName($data->givenName." ".$data->familyName);
            $clientActual->setEmail($data->email);
            $clientActual->setRegistrationDate(date('d/m/y'));
            $clientActual->setRegistrationComplete(0);
            $clientActual->insert($db);
            $_SESSION['user'] = $clientActual;
            // $_SESSION['auth'] = true;
            header("location:/signup/finishRegistration");
        }else{
            $_SESSION['user'] = $client;
            $_SESSION['auth'] = true;
            header("location:/");
        }

    }
}

?>