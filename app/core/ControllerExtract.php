<?php

namespace app\core;
use app\classes\Uri;

class ControllerExtract
{
    public static function extract():string
    {
        $uri = Uri::uri();

        $folder = FolderExtract::extract($uri);
        // var_dump($folder);
        // die();
        if ($folder) {
            $controller = Uri::uriExist($uri, 1) ;
            $namespaceAndController = "app\\controllers\\".$folder."\\";
        } else {
            $controller = Uri::uriExist($uri, 0);
            $namespaceAndController = "app\\controllers\\".CONTROLLER_FOLDER_DEFAULT."\\";
        }

        // var_dump($namespaceAndController);
        // die();

        if (!$controller) {
            $controller = CONTROLLER_DEFAULT;
        }

        $controller = $namespaceAndController.$controller.'Controller';
        //  var_dump($controller);
        // die();

        if (class_exists($controller)) {
            return $controller;
        }

        throw new \Exception("Controller {$controller} não existe");
    }
}

?>