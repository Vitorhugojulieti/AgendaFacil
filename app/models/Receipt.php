<?php
namespace app\models;
use app\models\database\Db;
use app\models\Collaborator;
use app\interfaces\ModelInterface;

class Receipt implements ModelInterface{
    private int $id;
    private int $idCompany;
    private int $idCollaborator;
    private float $amount;
    private \DateTime $dateReceipt;
    private string $table = "receipts";

    public function __construct($amount = 0.0, 
                                $idCollaborator = 0, 
                                $idCompany = 0,
                                $dateReceipt = new \DateTime()
                                ){
        $this->amount = $amount;
        $this->idCollaborator = $idCollaborator;
        $this->idCompany = $idCompany;
        $this->dateReceipt = $dateReceipt;
    }

    public function totalRecords(Db $db){
        $db->setTable($this->table);
        $total = $db->totalRecords("Company_idCompany = {$this->getIdCompany()}");
        return $total[0]['total'];
    }

    public function getReceiptsByFilters(
        Db $db,
        int $idCompany,
        string $startDate = "",
        string $endDate = "",
        int $collaboratorId = 0,
    ) {
        $db->setTable($this->table);
        $where = "Company_idCompany = {$idCompany}";
    
        if ($startDate != "" && $endDate != "") {
            $where .= " AND created_at BETWEEN '{$startDate}' AND '{$endDate}'";
        }
    
        if ($collaboratorId > 0) {
            $where .= " AND idCollaborator = {$collaboratorId}";
        }

        $where .= " AND idCollaborator != {$collaboratorId}";

   
        $receipts = $db->query("*", $where);
    
        $arrayObjectsReceipt = [];
    
        foreach ($receipts as $receipt) {
            $newReceipt = new Receipt(
                floatval($receipt['total']), 
                intval($receipt['idCollaborator']) ,
                intval($receipt['company_idCompany']), 
                new \DateTime($receipt['created_at'])
            );
    
            $newReceipt->setId($receipt['idReceipt']);
            $arrayObjectsReceipt[] = $newReceipt;
        }
    
        return $arrayObjectsReceipt;
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


    public function getByCompany(Db $db,int $idCompany, int $currentPage = 1, int $recordsPerPage = 10){
        $db->setTable($this->table);
        $where = "Company_idCompany = {$idCompany}";
        $paginationResult= $db->paginate($currentPage, $recordsPerPage, "*", $where);
        $services = $paginationResult['data'];
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
           
        return [
            'services' => $arrayObjectsService,
            'pagination' => [
                'currentPage' => $paginationResult['currentPage'],
                'recordsPerPage' => $paginationResult['recordsPerPage'],
                'totalRecords' => $paginationResult['totalRecords'],
                'totalPages' => $paginationResult['totalPages']
            ]
        ];
    }


    public function insert(DB $db){
        $db->setTable($this->table);
        
            $data = [
                'total' => $this->getAmount(),
                'Company_idCompany' => $this->getIdCompany(),
                'idCollaborator' => $this->getIdCollaborator(),
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
        return $db->delete("idService={$id} AND Company_idCompany={$this->getIdCompany()}");
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

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }

    public function getIdCollaborator(): int {
        return $this->idCollaborator;
    }

    public function setIdCollaborator(int $idCollaborator): void {
        $this->idCollaborator = $idCollaborator;
    }

    public function getDateReceipt(): \DateTime {
        return $this->dateReceipt;
    }

    public function setDateReceipt(\DateTime $dateReceipt): void {
        $this->dateReceipt = $dateReceipt;
    }

    public function getCollaborator(){
        $db = new Db();
        $db->connect();
        $collaborator = new Collaborator();
        $collaborator = $collaborator->getById($db,$this->getIdCollaborator());
        return $collaborator ? $collaborator : '';
    }
}

?>