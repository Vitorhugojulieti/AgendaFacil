<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use app\models\Service;
use app\models\Schedule;
use app\models\Images;

class Images {
    private int $id;
    private string $link;
    private string $typeImage;
    private int $idCompany;
    private int $idService;
    private string $table = "images";


    public function __construct($idCompany = 0,$typeImage = "", $link = "",$idService = 0){
        $this->idCompany = $idCompany;
        $this->typeImage = $typeImage;
        $this->link = $link;
        $this->idService = $idService;
    }


    public function getByService($db,$idService,$idCompany){
        $db->setTable($this->table);
        $imagesFound = $db->query("*","idService='{$idService}' AND Company_idCompany = {$idCompany}");
        return $imagesFound;
    }

    public function getByCompany($db,$idCompany){
        $db->setTable($this->table);
        $imagesFound = $db->query("*","Company_idCompany='{$idCompany}'");
        return $imagesFound;
    }

    public function insert(Db $db, $data =""){
        $db->setTable($this->table);
        
        if(!$data){
            $data = [
                'link' => $this->getLink(),
                'typeImage' => $this->getTypeImage(),
                'Company_idCompany' => $this->getIdCompany(),
                'idService' => $this->getIdService(),
            ];
    
            if($db->insert($data)){
                return true;
            }
            return false;
        }
       
        // insert container images
        $insertSucess = true;

        for ($i=0; $i < count($data); $i++) { 
            if(!$db->insert($data[$i])){
                $insertSucess = false;
            } 
        }

        return $insertSucess;
    }

    public function updateImageService($db,$idImage,$idCompany,$idService){
        $db->setTable($this->table);
        $data = [];
        if ($this->getIdCompany() !== 0 || $this->getId() !== 0) {
            return false;
        }

        if ($this->getLink() !== '') {
            $data['link'] = $this->getLink();
        }
        if ($this->getTypeImage() !== '') {
            $data['typeImage'] = $this->getTypeImage();
        }
        if ($this->getIdService() !== '') {
            $data['idService'] = $this->getIdService();
        }

        if(!empty($data)){
            if($db->update("idImage={$idImage} AND Company_idCompany = {$idCompany} AND idService = {$idService}",$data)){
                return true;
            }
        }
    }

    public function updateImageCompany($db,$idImage,$idCompany){
        $db->setTable($this->table);
        $data = [];
        if ($this->getIdCompany() !== 0 || $this->getId() !== 0) {
            return false;
        }

        if ($this->getLink() !== '') {
            $data['link'] = $this->getLink();
        }
        if ($this->getTypeImage() !== '') {
            $data['typeImage'] = $this->getTypeImage();
        }
        if ($this->getIdService() !== '') {
            $data['idService'] = $this->getIdService();
        }

        if(!empty($data)){
            if($db->update("idImage={$idImage} AND Company_idCompany = {$idCompany}",$data)){
                return true;
            }
        }
    }

    public function destroy($db,$idImage){
        $db->setTable($this->table);
        return $db->delete("idImage={$idImage}");
    }

    //getters and setters
    public function getIdCompany() {
        return $this->idCompany;
    }

    public function setIdCompany($idCompany) {
        $this->idCompany = $idCompany;
    }

    public function getTypeImage() {
        return $this->typeImage;
    }

    public function setTypeImage($typeImage) {
        $this->typeImage = $typeImage;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getIdService() {
        return $this->idService;
    }

    public function setIdService($idService) {
        $this->idService = $idService;
    }

}
?>