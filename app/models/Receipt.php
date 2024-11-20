<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;

class Receipt implements ModelInterface{
    private int $id;
    private int $idCompany;
    private int $idCollaborator;
    private float $amount;
    private string $table = "receipts";

    public function __construct($amount = 0.0, 
                                $idCollaborator = 0, 
                                $idCompany = 0
                                ){
        $this->amount = $amount;
        $this->idCollaborator = $idCollaborator;
        $this->idCompany = $idCompany;
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

    public function getServicesByFilters(Db $db, int $idCompany, int $maxPrice = 0, int $maxDuration = 0, string $status = "", int $currentPage = 1, int $recordsPerPage = 10) {
        $db->setTable($this->table);
        $where = "Company_idCompany = {$idCompany}";
    
        // Filtro por preço
        if ($maxPrice != 0) {
            $where .= " AND price <= {$maxPrice}";
        }
    
        // Filtro por duração
        if ($maxDuration != 0) {
            $hours = (($maxDuration - 60) / 10) == 0 ? 1 : (($maxDuration - 60) / 10) + 1;
            if ($hours > 0 && $hours < 4) {
                $where .= " AND duration <= '0{$hours}:00:00'";
            } else {
                $where .= " AND duration <= '00:{$maxDuration}:00'";
            }
        }
    
        // Filtro por status
        if ($status != "") {
            $where .= " AND visible = {$status}";
        }
    
        // Realiza a paginação com os filtros
        $paginationResult = $db->paginate($currentPage, $recordsPerPage, "*", $where);
        $services = $paginationResult['data'];
        $arrayObjectsService = [];
    
        // Cria objetos Service a partir dos resultados
        foreach ($services as $service) {
            $newService = new Service(
                $service['name'],
                $service['description'],
                $service['price'],
                new \DateTime($service['duration']),
                $service['Company_idCompany'],
                $service['visible'],
                new \DateTime($service['created_at'])
            );
    
            $newService->setId($service['idService']);
            $arrayObjectsService[] = $newService;
        }
    
        // Retorna o array de objetos Service e os dados de paginação
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

}

?>