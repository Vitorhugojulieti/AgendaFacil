<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use app\models\Client;
use app\models\Schedule;

class Evaluation implements ModelInterface{
    private int $id;
    private float $note;
    private int $idService;
    private int $idCompany;
    private int $idClient;
    private \DateTime $createDate;
    private string $feedback;
    private string $table = "evaluations";

    public function __construct($note = 0, 
                                $idService = 0, 
                                $idCompany = 0, 
                                $idClient = 0, 
                                $createDate = new \DateTime(),
                                $feedback = ''
                                )
    {
        $this->note = floatval($note);
        $this->idService = $idService;
        $this->idCompany = $idCompany;
        $this->idClient = $idClient;
        $this->createDate = $createDate;
        $this->feedback = $feedback;
    }

    // public function totalRecords(Db $db){
    //     $db->setTable($this->table);
    //     $total = $db->totalRecords("Company_idCompany = {$this->getIdCompany()}");
    //     return $total[0]['total'];
    // }

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
        $client = new Client();
        $evaluations = $db->query("*","Services_Company_idCompany={$idCompany}");
        $arrayEvaluations =[];
        foreach ($evaluations as $evaluation){
            $newEvaluation = new Evaluation($evaluation['note'],
                                    $evaluation['Services_idService'],
                                    $evaluation['Services_Company_idCompany'],
                                    $evaluation['Client_idClient'],
                                    new \DateTime($evaluation['created_at']),
                                    $evaluation['feedback']
                                    );

            $newEvaluation->setId($evaluation['idEvaluation']);
            $newEvaluation->setClient($client->getById($db,$evaluation['Client_idClient']));
            array_push($arrayEvaluations,$newEvaluation);
        }
        return $arrayEvaluations;
    }

    public function insert(DB $db){
        $db->setTable($this->table);
        
            $data = [
                'note' => $this->getNote(),
                'Services_idService' => $this->getIdService(),
                'Services_Company_idCompany' => $this->getIdCompany(),
                'Client_idClient' => $this->getIdClient(),
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
            $data['note'] = $this->getName();
        }
        if ($this->getDescription() !== '') {
            $data['Services_idService'] = $this->getDescription();
        }
        if ($this->getPrice() !== '') {
            $data['Services_Company_idCompany'] = $this->getPrice();
        }
        if ($this->getDuration() !== '') {
            $data['Client_idClient'] = $this->getDuration();
        }

        if(!empty($data)){
            if($db->update("idEvaluation={$id} AND Services_Company_idCompany={$this->getIdCompany()}",$data)){
                return true;
            }
        }
        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idEvaluation={$id}");
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

    public function getNote(): float {
        return $this->note;
    }

    public function setNote(float $note): void {
        $this->note = $note;
    }

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }
    
    public function getIdClient(): int {
        return $this->idCompany;
    }

    public function setIdClient(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function getIdService(): int {
        return $this->idCompany;
    }

    public function setIdService(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function setClient(Client $client): void{
        $this->client = $client;
    }

    public function getClient(): Client{
        return $this->client;
    }

    public function setFeedback(string $feedback): void{
        $this->feedback = $feedback;
    }

    public function getFeedback(): string{
        return $this->feedback;
    }

}

?>