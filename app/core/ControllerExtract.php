<?php

namespace app\core;
use app\classes\Uri;

class ControllerExtract
{
    public static function extract():string
    {
        $uri = Uri::uri();

        $folder = FolderExtract::extract($uri);
        if ($folder) {
            $controller = Uri::uriExist($uri, 1);
            $namespaceAndController = "app\\controllers\\".$folder."\\";
        } else {
            $controller = Uri::uriExist($uri, 0);
            $namespaceAndController = "app\\controllers\\".CONTROLLER_FOLDER_DEFAULT."\\";
        }

        if (!$controller) {
            $controller = CONTROLLER_DEFAULT;
        }

        $controller = $namespaceAndController.$controller.'Controller';
        if (class_exists($controller)) {
            return $controller;
        }

        throw new \Exception("Controller {$controller} não existe");
    }
}

?>