<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use app\models\Schedule;

class Service implements ModelInterface{
    private int $id;
    private string $name;
    private string $description;
    private string $price;
    private \DateTime $duration;
    private \DateTime $registrationDate;
    private int $visible;
    private int $idCompany;
    private array $collaborators;
    private array $images;
    private string $tableImages = "imagens";
    private string $table = "services";
    private string $tableCollaboratorsHasService = "collaborator_has_services";
    //atributte no db
    private int $amount =1;

    public function __construct($name = "", 
                                $description = "", 
                                $price = "", 
                                $duration = new \DateTime(), 
                                $idCompany = 0 ,
                                $visible = true,
                                $registrationDate = new \DateTime())
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->duration = $duration;
        $this->idCompany = $idCompany;
        $this->visible = $visible;
        $this->registrationDate = $registrationDate;
        $this->collaborators = [];
        $this->images = [];
    }

    public function totalRecords(Db $db){
        $db->setTable($this->table);
        $total = $db->totalRecords("Company_idCompany = {$this->getIdCompany()}");
        return $total[0]['total'];
    }

    public function getIdByName(Db $db, $name,$idCompany){
        $db->setTable($this->table);
        $idFound = $db->query("idService","name='{$name}' AND Company_idCompany = {$idCompany}");

        if(!$idFound){
            return false;
        }

        return $idFound[0]['idService'];
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $services = $db->query("*");
        $arrayObjectsService =[];
        foreach ($services as $service){
            $newService = new Service($service['name'],
                                    $service['description'],
                                    $service['price'],
                                    new \DateTime($service['duration']),
                                    $service['Company_idCompany'],
                                    $service['visible'],
                                    new \DateTime($service['created_at']));

            $newService->setId($service['idService']);
            array_push($arrayObjectsService,$newService);
        }
        return $arrayObjectsService;

        //logica para trazer imagens
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $serviceFound = $db->query("*","idService={$id}");

        if(!$serviceFound){
            return false;
        }

        $serviceObject = new Service($serviceFound[0]['name'],
                                    $serviceFound[0]['description'],
                                    $serviceFound[0]['price'],
                                    new \DateTime($serviceFound[0]['duration']),
                                    $serviceFound[0]['Company_idCompany'],
                                    $serviceFound[0]['visible'],
                                    new \DateTime($serviceFound[0]['created_at']));

        $serviceObject->setId($serviceFound[0]['idService'],);
        //logica para trazer imagens
        $imagesManager = new Images();
        $images = $imagesManager->getByService($db,$id,$serviceFound[0]['Company_idCompany']);
        $serviceObject->setImages($images);
     
        return $serviceObject;
    }


    public function getByCompany(Db $db,int $idCompany){
        $db->setTable($this->table);
        $services = $db->query("*","Company_idCompany={$idCompany}");
        $arrayObjectsService =[];
        foreach ($services as $service){
            $newService = new Service($service['name'],
                                    $service['description'],
                                    $service['price'],
                                    new \DateTime($service['duration']),
                                    $service['Company_idCompany'],
                                    $service['visible'],
                                    new \DateTime($service['created_at']));

            $newService->setId($service['idService']);
            array_push($arrayObjectsService,$newService);
        }
        return $arrayObjectsService;
    }

    public function getCollaborators(){
        $db = new Db();
        $db->connect();

        $collaboratorManager = new Collaborator();
        $db->setTable($this->tableCollaboratorsHasService);
        $idsCollaborators = $db->query("Collaborator_idCollaborator","Services_idService={$this->getId()} AND Collaborator_Company_idCompany={$this->getIdCompany()}");
        $arrayObjCollaborators = [];
        foreach ($idsCollaborators as $idCollaborator) {
            array_push($arrayObjCollaborators,$collaboratorManager->getById($db,$idCollaborator["Collaborator_idCollaborator"]));
        }
        return $arrayObjCollaborators;
    }

    public function insert(DB $db){
        $db->setTable($this->table);
        
            $data = [
                'name' => $this->getName(),
                'description' => $this->getDescription(),
                'price' => $this->getPrice(),
                'duration' => $this->getDuration(),
                'Company_idCompany' => $this->getIdCompany(),
                'visible' => $this->getVisible(),
            ];
    
            $data = array_map(function($value) {
                return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
            }, $data);

            if($db->insert($data)){
                return true;
            }

            return false;
    }


    public function update(Db $db,int $id){
        $db->setTable($this->table);
        $data = [];
      
        if ($this->getName() !== '') {
            $data['name'] = $this->getName();
        }
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

        $data = array_map(function($value) {
            return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
        }, $data);

        
        if(!empty($data)){
            if($db->update("idService={$id} AND Company_idCompany={$this->getIdCompany()}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idService={$id}");
    }

    public function removeAttribute($attribute) {
        if (property_exists($this, $attribute)) {
            unset($this->$attribute);
        }
    }

    //getters and setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getPrice(): string {
        return $this->price;
    }

    public function setPrice(string $price): void {
        $this->price = $price;
    }

    public function getDuration(): \DateTime {
        return $this->duration;
    }

    public function setDuration(\DateTime $duration): void {
        $this->duration = $duration;
    }

    public function getVisible(): int {
        return $this->visible;
    }

    public function setVisible(int $visible): void {
        $this->visible = $visible;
    }

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function getImage($index): string {
        return $this->images[$index]['link'];
    }

    public function setImages(array $images): void {
        $this->images = $images;
    }

    public function getRegistrationDate(): \DateTime {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTime $registrationDate): void {
        $this->registrationDate = $registrationDate;
    }

    //atributte no db
    public function getAmount(): int {
        return $this->amount;
    }

    public function setAmount(int $amount): void {
        $this->amount = $amount;
    }
}

?>