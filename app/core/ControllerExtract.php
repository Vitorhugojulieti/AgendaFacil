<?php
namespace app\core;
use app\classes\Uri;

class ControllerExtract{
    public static function extract(){
        $uri = Uri::uri();

        $controller = 'HomeController';

        if(isset($uri[0]) and $uri[0] !== ''){
            $controller = ucfirst($uri[0]).'Controller';
        }

        $namespaceAndController = "app\\controllers\\".$controller;

        if(class_exists($namespaceAndController)){
            $controller = $namespaceAndController;
        }

        return $controller;
    }
}

?>