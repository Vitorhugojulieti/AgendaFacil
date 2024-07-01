<?php
 use app\classes\Flash;
 function flash($key){
    $flash = Flash::get($key);

    if(isset($flash['message'])){
        return "<span class='{$flash['alert']}'>{$flash['message']}</span>";
    }
 }

?>