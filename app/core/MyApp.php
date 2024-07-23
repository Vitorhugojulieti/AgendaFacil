<?php
namespace app\core;
require '../app/exceptions/exception.php';

use Exception;
use app\interfaces\AppInterface;

class MyApp {
    private $controller;

    public function __construct(private AppInterface $AppInterface){

    }

    public function controller(){
        $controller = $this->AppInterface->controller();
        $method = $this->AppInterface->method($controller );
        $params = $this->AppInterface->params();
        
        $this->controller = new $controller;
        $this->controller->$method($params);
    }

    public function view(){
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(!isset($this->controller->data)){
                throw new Exception('Data é obrigatorio');
            }
        
            if(!array_key_exists('title',$this->controller->data)){
                throw new Exception('a propriedade title é obrigatoria em data');
            }

            if (!isset($this->controller->master)) {
                throw new Exception('A propriedade master é obrigatória');
            }

            extract($this->controller->data);
            require '../app/views/'.$this->controller->master;
        }
    }
}



?>