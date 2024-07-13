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
    private string $duration;
    private bool $visible;
    private int $idCompany;
    //configurar relação servico - colaborador para muitos para muitos
    private array $collaborators;
    private array $images;
    private string $tableImages;
    private string $table = "services";


    public function __construct($name = "", $description = "", $price = "", $duration = "", $idCompany = 0 ,$visible = true){
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->duration = $duration;
        $this->idCompany = $idCompany;
        $this->visible = $visible;
        $this->tableImages = "imagens";
        $this->collaborators = [];
        $this->images = [];
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $services = $db->query("*");
        $arrayObjectsService =[];
        foreach ($services as $service){
            $newService = new Service($service['name'],$service['description'],$service['price'],$service['duration'],$service['Company_idCompany'],$service['visible']);
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

        $serviceObject = new Service($serviceFound[0]['name'],$serviceFound[0]['description'],$serviceFound[0]['price'],$serviceFound[0]['duration'],$serviceFound[0]['Company_idCompany'],$serviceFound[0]['visible']);
        $serviceObject->setId($serviceFound[0]['idService'],);
        return $serviceObject;
        //logica para trazer imagens

    }

    public function getByIdCollaborator(Db $db){

    }

    public function getByIdCompany(Db $db){

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

    public function getDuration(): string {
        return $this->duration;
    }

    public function setDuration(string $duration): void {
        $this->duration = $duration;
    }

    public function getVisible(): bool {
        return $this->visible;
    }

    public function setVisible(bool $visible): void {
        $this->visible = $visible;
    }

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }
}

?>