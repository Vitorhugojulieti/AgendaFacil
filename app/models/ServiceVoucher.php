<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;

// TODO adicionar paginação
// TODO adicionar filtros
//TODO criar table client_has_serviceVoucher
class ServiceVoucher implements ModelInterface{
    private int $id;
    private int $idCompany;
    private int $duration;
    private int $discount;
    private string $name;
    private float $amount;
    private \DateTime $dateOfIssue;
    private \DateTime $dateExpiration;
    private string $code;
    private string $description;
    private int $active;
    private string $table = "servicevoucher";
    private string $tableServices = "servicevoucher_has_services";
    private array $services = [];

    public function __construct($idCompany = 0,
                                $name = "",
                                $amount = 0.00,
                                $dateExpiration = new \DateTime(), 
                                $code = "",
                                $active = 1,
                                $description = "",
                                $dateOfIssue = new \DateTime(), 
                                $duration = 0,
                                $discount = 0
                                )
    {
        $this->idCompany = $idCompany;
        $this->name = $name;
        $this->amount = (Float)$amount;
        $this->dateOfIssue = $dateOfIssue;
        $this->dateExpiration = $dateExpiration;
        $this->code = $code;
        $this->description = $description;
        $this->active = $active;
        $this->duration = $duration;
        $this->discount = $discount;
    }

    public function getLastRecord(Db $db){
        $db->setTable($this->table);
        $query = "SELECT idServiceVoucher FROM servicevoucher ORDER BY created_at DESC LIMIT 1";
        $lastRecord = $db->executeSQL($query);
        return $lastRecord[0]['idServiceVoucher'];
    }

    public function getByAttribute(Db $db, int $idCompany, $attribute, $value){
        //TODO adicionar validacoes
        $db->setTable($this->table);
        $vouchers = $db->query("*","{$attribute}='{$value}'  AND Company_idCompany={$idCompany}");

        $arrayObjectsVouchers =[];
        foreach ($vouchers as $voucher){
            $voucherObj = new ServiceVoucher($voucher['Company_idCompany'],
                                            $voucher['name'],
                                            $voucher['amount'],
                                            new \DateTime($voucher['dateExpiration']),
                                            $voucher['code'],
                                            $voucher['active'],
                                            $voucher['description'],
                                            new \DateTime($voucher['created_at']),
                                            $voucher['duration'],
                                            $voucher['discount']);

            $voucherObj->setId($voucher['idServiceVoucher']);
            array_push($arrayObjectsVouchers,$voucherObj);
        }
        return $arrayObjectsVouchers;
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $vouchers = $db->query("*");
        $arrayObjectsVouchers =[];
        foreach ($vouchers as $voucher){
            $voucherObj = new ServiceVoucher($voucher['Company_idCompany'],
                                            $voucher['name'],
                                            $voucher['amount'],
                                            new \DateTime($voucher['dateExpiration']),
                                            $voucher['code'],
                                            $voucher['active'],
                                            $voucher['description'],
                                            new \DateTime($voucher['created_at'],
                                            $voucher['duration']),
                                            $voucher['discount']
                                        );

            $voucherObj->setId($voucher['idServiceVoucher']);
            array_push($arrayObjectsVouchers,$voucherObj);
        }
        return $arrayObjectsVouchers;
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $voucherFound = $db->query("*","idServiceVoucher={$id}");

        if(!$voucherFound){
            return false;
        }

        $voucherObject = new ServiceVoucher($voucherFound[0]['Company_idCompany'],
                                            $voucherFound[0]['name'],
                                            $voucherFound[0]['amount'],
                                            new \DateTime($voucherFound[0]['dateExpiration']),
                                            $voucherFound[0]['code'],
                                            $voucherFound[0]['active'],
                                            $voucherFound[0]['description'],
                                            new \DateTime($voucherFound[0]['created_at']),
                                            $voucherFound[0]['duration'],
                                            $voucherFound[0]['discount']
                                        );

        $voucherObject->setId($voucherFound[0]['idServiceVoucher']);
        $voucherObject->getServicesDb($db,$voucherFound[0]['idServiceVoucher']);
        return $voucherObject;
    }

    // TODO atualizar metodo getByClient
    public function getByClient(Db $db, int $idClient){
        $db->setTable($this->table);
        $voucherFound = $db->query("*","idServiceVoucher={$id}");

        if(!$voucherFound){
            return false;
        }

        $voucherObject = new ServiceVoucher($voucherFound[0]['Company_idCompany'],
                                            $voucherFound[0]['name'],
                                            $voucherFound[0]['amount'],
                                            new \DateTime($voucherFound[0]['dateExpiration']),
                                            $voucherFound[0]['code'],
                                            $voucherFound[0]['active'],
                                            $voucherFound[0]['description'],
                                            new \DateTime($voucherFound[0]['created_at']),
                                            $voucherFound[0]['duration'],
                                            $voucherFound[0]['discount']
                                        );

        $voucherObject->setId($voucherFound[0]['idServiceVoucher']);
        $voucherObject->getServicesDb($db);
        return $voucherObject;
    }

    public function getByCompany(Db $db, int $idCompany, int $currentPage = 1, int $recordsPerPage = 10) {
        $db->setTable($this->table);
        $where = "Company_idCompany = {$idCompany}";
        $paginationResult= $db->paginate($currentPage, $recordsPerPage, "*", $where);
        $paginationVouchers = $paginationResult['data'];
        $arrayObjectsVouchers = [];
    
        // Criar objetos ServiceVoucher para cada voucher retornado
        foreach ($paginationVouchers as $voucher) {
            $voucherObj = new ServiceVoucher(
                $voucher['Company_idCompany'],
                $voucher['name'],
                $voucher['amount'],
                new \DateTime($voucher['dateExpiration']),
                $voucher['code'],
                $voucher['active'],
                $voucher['description'],
                new \DateTime($voucher['created_at']),
                $voucher['duration'],
                $voucher['discount']
            );
            $voucherObj->setId($voucher['idServiceVoucher']);
            $voucherObj->getServicesDb($db);
            array_push($arrayObjectsVouchers, $voucherObj);
        }
    
        // Retornar os vouchers paginados junto com as informações de paginação
        return [
            'vouchers' => $arrayObjectsVouchers,
            'pagination' => [
                'currentPage' => $paginationResult['currentPage'],
                'recordsPerPage' => $paginationResult['recordsPerPage'],
                'totalRecords' => $paginationResult['totalRecords'],
                'totalPages' => $paginationResult['totalPages']
            ]
        ];
    }
    

    public function insert(Db $db){
        $db->setTable($this->table);
        $data = [
            'Company_idCompany'=>$this->getIdCompany(),
            'name'=>$this->getName(),
            'amount' => $this->getAmount(),
            'dateExpiration' => $this->getDateExpiration(),
            'code' => $this->getCode(),
            'active' => $this->getActive(),
            'description'=>$this->getDescription(),
            'duration'=>$this->getDuration(),
            'discount'=>$this->getDiscount(),
        ];

        $data = array_map(function($value) {
            return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
        }, $data);

        if ($db->insert($data)) {
            return $this->getLastRecord($db);
        }
        return false;
    }

    public function insertServices($db,array $services){
        $db->setTable($this->tableServices);
        $confirm = true;
        foreach ($services as $service) {
            $data = [
                'serviceVoucher_idServiceVoucher'=>$this->getId(),
                'Services_idService'=>$service->getId(),
                'Services_Company_idCompany' => $service->getIdCompany(),
                'amount' => $service->getAmount(),
            ];

            if (!$db->insert($data)) {
                $confirm = false;
            }
        }
        return $confirm;
    }

    public function updateAmountForServices(Db $db, array $services){
        $db->setTable($this->tableServices);
        $update = true;
        foreach ($services as $service) {
            if ($service->getAmount() !== 0) {
                $data['amount'] = $service->getAmount();
            }
            if(!$db->update("serviceVoucher_idServiceVoucher={$this->getId()} AND Services_idService={$service->getId()}",$data)){
                $update = false;
            }
        }
       return $update;
    }

    public function removeService(Db $db, $idService){
        $db->setTable($this->tableServices);
        return $db->delete("serviceVoucher_idServiceVoucher={$this->getId()} AND Services_idService={$idService}");
    }

    public function update(Db $db,int $id){
        $db->setTable($this->table);
        $data = [];
        
        if ($this->getName() !== "") {
            $data['name'] = $this->getName();
        }
        if ($this->getAmount() !== 0) {
            $data['amount'] = $this->getAmount();
        }
        if ($this->getActive() !== '') {
            $data['active'] = $this->getActive();
        }
        if ($this->getDescription() !== '') {
            $data['description'] = $this->getDescription();
        }
        if ($this->getDuration() !== '') {
            $data['duration'] = $this->getDuration();
        }
        if ($this->getDiscount() !== '') {
            $data['discount'] = $this->getDiscount();
        }
       
        if(!empty($data)){
            if($db->update("idServiceVoucher={$id}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idServiceVoucher={$id} AND Company_idCompany={$this->getIdCompany()}");
    }

    //getters and setters
    private function getServicesDb(Db $db): void{
        $db->setTable($this->tableServices);
        $services = $db->query("Services_idService , amount","serviceVoucher_idServiceVoucher={$this->getId()}");
        $serviceManager = new Service();
        $arrayServices = [];

        if($services){
            foreach ($services as $service) {
                $objService = $serviceManager->getById($db,$service['Services_idService']);
                $objService->setAmount($service['amount']);
                array_push($arrayServices,$objService);
            }
        }

        $this->services = $arrayServices;
    }

    public function getServices(): array{
        return $this->services;
    }

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

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function getAmount():float {
        return $this->amount;
    }

    public function setAmount(float $amount) {
        $this->amount = $amount;
    }

    public function getDateOfIssue() {
        return $this->dateOfIssue;
    }

    public function setDateOfIssue(\DateTime $dateOfIssue) {
        $this->dateOfIssue = $dateOfIssue;
    }

    public function getDateExpiration() {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTime $dateExpiration) {
        $this->dateExpiration = $dateExpiration;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode(string $code) {
        $this->code = $code;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive(int $active) {
        $this->active = $active;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function setDuration(int $duration): void {
        $this->duration = $duration;
    }

    public function getDiscount(): int {
        return $this->discount;
    }

    public function setDiscount(int $discount): void {
        $this->discount = $discount;
    }
}
?>