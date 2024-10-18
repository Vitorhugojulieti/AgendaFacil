<?php
namespace app\classes;
use app\models\Service;

class Cart{
    public static function initialize(array $services){
        $_SESSION['cart'] = $services;
    }

    public static function get(){
        if(isset($_SESSION['cart'])){
            return $_SESSION['cart'];
        }

        return [];
    }

    public static function getIdCompany(){
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            $cart = array_values($_SESSION['cart']);
            return $cart[0]->getIdCompany();
        }
        return false;
    }
    public static function getAmount(){
        $amount = 0.00;
        if(isset($_SESSION['cart'])&& !empty($_SESSION['cart'])){
            foreach ($_SESSION['cart'] as $service) {
                $amount += $service->getPrice() * $service->getAmount();
            }
            return $amount;
        }else{
            return 0.00;
        }
    }
    
    public static function add(Service $service){
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            if(Cart::inToCart($service)){
                foreach ($_SESSION['cart'] as $serviceCart) {
                    if($serviceCart->getId() === $service->getId()){
                        $serviceCart->setAmount($serviceCart->getAmount()+1);
                    }
                }
            }else{
                array_push($_SESSION['cart'], $service);
            }
        } else {
            $_SESSION['cart'] = [$service];
        }
    }
    
    
    public static function inToCart(Service $service){
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
                return $service->getId() != $id;
            });
        }
    }

    public static function removeOne($id){
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            foreach ($_SESSION['cart'] as $serviceCart) {
                if($serviceCart->getId() == $id){
                    if($serviceCart->getAmount() != 1){
                        $serviceCart->setAmount($serviceCart->getAmount()-1);
                    }else{
                        Cart::remove($id);
                    }
                }
            }
        }
    }

    public static function applyDiscount($porcent = 0,$amount){
        if($porcent === 0){
            return $amount * 1;
        }else{
            return $amount * ($porcent/100);
        }
    }
    
    public static function delete(){
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            unset($_SESSION['cart']);
        }
    }

    public static function showDuration() {
        $totalTime = new \DateInterval('PT0H0M');
        $now = new \DateTime();
        $baseDateTime =new \DateTime($now->format('Y-m-d') . ' 00:00:00');
    
        foreach ($_SESSION['cart'] as $service) {
            $duration = $service->getDuration(); // Isso é um DateTime
            
            // Calcula a diferença entre a baseDateTime e a duração
            $interval = $baseDateTime->diff($duration);
            
            // Adiciona o intervalo à totalTime
            $totalTime->h += $interval->h;
            $totalTime->i += $interval->i;
            $totalTime->s += $interval->s;
    
            // Normaliza o tempo
            if ($totalTime->s >= 60) {
                $totalTime->i += intdiv($totalTime->s, 60);
                $totalTime->s %= 60;
            }
            if ($totalTime->i >= 60) {
                $totalTime->h += intdiv($totalTime->i, 60);
                $totalTime->i %= 60;
            }
        }
        if ($totalTime->h === 0) {
            return $totalTime->i.' min';
        } else {
            return $totalTime->h.' Hr '.$totalTime->i.' min';
        }
    }
}
?>