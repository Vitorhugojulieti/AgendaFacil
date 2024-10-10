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
        // $staticMapUrl = "https://maps.googleapis.com/maps/api/staticmap?center=" . urlencode($adress) . "&zoom=15&size=600x300&markers=color:red|" . urlencode($adress) . "&key=" . $apiKey;
        // $mapsUrl = "https://www.google.com/maps/search/?api=1&query=" . urlencode($adress);

        $map = "https://www.google.com/maps/embed/v1/place?key=" . $apiKey . "&q=" . urlencode($adress);
        // return "<a href='$mapsUrl' target='_blank' class='w-full'><img src='$staticMapUrl' alt='Localização no Google Maps'></a>";
        return "<iframe width='100%' height='200' frameborder='0' style='border:0' src='$map' allowfullscreen></iframe>";
    }

}


?>