<?php
namespace app\classes;

class Maps{
    private string $cep;
    private int $number;

    public function setCep(string $cep){
        $this->cep = $cep;
    }

    public function setNumber(int $number){
        $this->number = $number;
    }

    public function getMap(){
        $adress = $this->cep . " " . $this->number;
        $apiKey = $_ENV['MAPS_KEY'];
        $map = "https://www.google.com/maps/embed/v1/place?key=" . $apiKey . "&q=" . urlencode($adress);
        // return "<a href='$mapsUrl' target='_blank' class='w-full'><img src='$staticMapUrl' alt='Localização no Google Maps'></a>";
        return "<iframe width='100%' height='200' frameborder='0' style='border:0' src='$map' allowfullscreen></iframe>";
    }

}


?>