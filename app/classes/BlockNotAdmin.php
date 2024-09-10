<?php
namespace app\classes;
use app\classes\Block;
use app\classes\BlockPostRequest;
use app\interfaces\ControllerInterface;

class BlockNotAdmin{
    public static function block(ControllerInterface $controllerInterface, array $blockMethods){
        $canBlockMethod = Block::getMethodToBlock($controllerInterface, $blockMethods);
        
        if((!isset($_SESSION['collaborator']) || $_SESSION['collaborator']->getNivel() !== 'manager')  and $canBlockMethod){
            BlockPostRequest::block();
            return redirect('/admin/signup');
        } 
    }
}

?>