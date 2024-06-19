<?php
namespace app\core;
use app\interfaces\AppInterface;
use app\classes\Uri;
use app\core\ControllerExtract;
use app\core\MethodExtract;
use app\core\ParamsExtract;


class AppExtract implements AppInterface{
    private int $sliceIndexStartFrom;

    public function controller():string{
        return ControllerExtract::extract();
    }

    public function method($controller):string{
       [$method, $sliceIndexStartFrom] = MethodExtract::extract($controller);
       $this->sliceIndexStartFrom = $sliceIndexStartFrom;
       return $method;
    }

    public function params():array{
      return ParamsExtract::extract($this->sliceIndexStartFrom);
    }
}
?>