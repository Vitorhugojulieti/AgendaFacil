<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use app\models\Service;
use app\models\Schedule;

class Images {
    private int $id;
    private string $link;
    private string $typeImage;
    private int $idCompany;
    private string $table = "images";


    public function __construct($idCompany = 0,$typeImage = "", $link = ""){
        $this->idCompany = $idCompany;
        $this->typeImage = $typeImage;
        $this->link = $link;
    }

  

    // public function getAll(Db $db){
    //     $db->setTable($this->table);
    //     $services = $db->query("*");
    //     $arrayObjectsService =[];
    //     foreach ($services as $service){
    //         $newService = new Service($service['name'],$service['description'],$service['price'],$service['duration'],$service['Company_idCompany'],$service['visible']);
    //         $newService->setId($service['idService']);
    //         array_push($arrayObjectsService,$newService);
    //     }
    //     return $arrayObjectsService;

    //     //logica para trazer imagens
    // }

    // public function getById(Db $db, int $id){
    //     $db->setTable($this->table);
    //     $serviceFound = $db->query("*","idService={$id}");

    //     if(!$serviceFound){
    //         return false;
    //     }

    //     $serviceObject = new Service($serviceFound[0]['name'],$serviceFound[0]['description'],$serviceFound[0]['price'],$serviceFound[0]['duration'],$serviceFound[0]['Company_idCompany'],$serviceFound[0]['visible']);
    //     $serviceObject->setId($serviceFound[0]['idService'],);
    //     return $serviceObject;
    //     //logica para trazer imagens

    // }

    // public function getByIdCollaborator(Db $db){

    // }

    // public function getByIdCompany(Db $db){

    // }

    public function insert(Db $db){
        $db->setTable($this->table);
        
            $data = [
                'link' => $this->getLink(),
                'typeImage' => $this->getTypeImage(),
                'Company_idCompany' => $this->getIdCompany(),
                'Services_idService' => 0,
                'Services_Company_idCompany' => $this->getIdCompany(),
            ];
    
            if($db->insert($data)){
                return true;
            }

            return false;

    }

    public function update(Db $db,int $id){
        $db->setTable($this->table);
        $data = [];
      
      
        if ($this->getDescription() !== '') {
            $data['description'] = $this->getDescription();
        }
        if ($this->getPrice() !== '') {
            $data['price'] = $this->getPrice();
        }
        if ($this->getDuration() !== '') {
            $data['duration'] = $this->getDuration();
        }
        if ($this->getIdCompany() !== '') {
            $data['Company_idCompany'] = $this->getIdCompany();
        }
        if ($this->getVisible() !== '') {
            $data['visible'] = $this->getVisible();
        }

        if(!empty($data)){
            if($db->update("idService={$id}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idService={$id}");
    }


    //getters and setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

  
    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function setLink($link){
        $this->link = $link;
    }

    public function getLink(){
        return $this->link;
    }
      
    public function getTypeImage(): string {
        return $this->idCompany;
    }

    public function setTypeImage(string $idCompany): void {
        $this->idCompany = $idCompany;
    }
}

?>