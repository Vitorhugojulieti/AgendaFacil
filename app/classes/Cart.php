<?php
namespace app\classes;

class Cart{
    public static function get(){
        if(isset($_SESSION['cart'])){
            return $_SESSION['cart'];
        }
    }

    public static function getIdCompany(){
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            return $_SESSION['cart'][0]->getIdCompany();
        }
    }
    public static function getAmount(){
        $amount = 0.00;
        foreach ($_SESSION['cart'] as $service) {
            $amount += $service->getPrice();
        }
        return $amount;
    }
    
    public static function add($service){
        if(isset($_SESSION['cart'])  && !empty($_SESSION['cart'])){
            if(!Cart::inToCart($service)){
                array_push($_SESSION['cart'],$service);
            }
        }else{
            $_SESSION['cart'] = [$service];
        }
    }
    
    public static function inToCart($service){
        if(isset($_SESSION['cart'])  && !empty($_SESSION['cart'])){
            $exist = false;
            foreach ($_SESSION['cart'] as $serviceCart) {
                if($serviceCart->getId() === $service->getId()){
                    $exist = true;
                }
            }
            return $exist;
        }
    }

    public static function remove($id){
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($service) use ($id) {
            return $service->getId() !== $id;
        });
    }
    }
    
    public static function delete(){
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            unset($_SESSION['cart']);
        }
    }
}
?>