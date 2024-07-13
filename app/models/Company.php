<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;

class Company implements ModelInterface{
    private int $id;
    private string $logo;
    private string $name;
    private string $cnpj;
    private string $phone;
    private string $cep;
    private string $road;
    private string $number;
    private string $city;
    private string $state;
    private string $plan;
    private string $category;
    private string $registrationDate;
    private int $registrationComplete;
    private string $table;

    public function __construct($logo = "", $name = "", $cnpj = "", $phone = "", $category = "", $cep = "", $road = "",$number = "",$state = "",$city = "", $plan = "", $registrationDate = "",$registrationComplete = 0){
        $this->logo = $logo;
        $this->name = $name;
        $this->cnpj = $cnpj;
        $this->phone = $phone;
        $this->cep = $cep;
        $this->road = $road;
        $this->city = $city;
        $this->state = $state;
        $this->number = $number;
        $this->plan = $plan;
        $this->category = $category;
        $this->registrationDate = $registrationDate;
        $this->registrationComplete = $registrationComplete;
        $this->table = "company";
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $companys = $db->query("*");
        $arrayObjectsCompany =[];
        foreach ($companys as $company){
            $newCompany = new Company($company['logo'],$company['name'],$company['cpf'],$company['cnpj'],$company['phone'],$company['email'],$company['cep'],$company['adress'],$company['plan'],$company['category'],$company['registrationDate'],$company['registrationComplete']);
            $newCompany->setId($company['id']);
            array_push($arrayObjectsCompany,$newCompany);
        }
        return $arrayObjectsCompany;
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $companyFound = $db->query("*","id={$id}");

        if(!$companyFound){
            return false;
        }

        $companyObject = new Company($companyFound[0]['logo'],$companyFound[0]['name'],$companyFound[0]['cpf'],$companyFound[0]['cnpj'],$companyFound[0]['phone'],$companyFound[0]['email'],$companyFound[0]['cep'],$companyFound[0]['adress'],$companyFound[0]['plan'],$companyFound[0]['category'],$companyFound[0]['registrationDate'],$companyFound[0]['registrationComplete']);
        $companyObject->setId($companyFound[0]['idCompany'],);
        return $companyObject;
    }

    public function getByCnpj(Db $db, string $cnpj){
        $db->setTable($this->table);
        $companyFound = $db->query("*","cnpj='{$cnpj}'");

        if(!$companyFound){
            return false;
        }

        $companyObject = new Company($companyFound[0]['logo'],$companyFound[0]['name'],$companyFound[0]['cpf'],$companyFound[0]['cnpj'],$companyFound[0]['phone'],$companyFound[0]['email'],$companyFound[0]['cep'],$companyFound[0]['adress'],$companyFound[0]['plan'],$companyFound[0]['category'],$companyFound[0]['registrationDate'],$companyFound[0]['registrationComplete']);
        $companyObject->setId($companyFound[0]['idCompany'],);
        return $companyObject;
    }

    public function getIdByCnpj(Db $db, string $cnpj){
        $db->setTable($this->table);
        $idFound = $db->query("idCompany","cnpj='{$cnpj}'");

        if(!$idFound){
            return false;
        }
        return $idFound[0]['idCompany'];
    }

    public function insert(Db $db){
        $db->setTable($this->table);
        
            $data = [
                'logo' => $this->getLogo(),
                'name' => $this->getName(),
                'cnpj' => $this->getCnpj(),
                'phone' => $this->getPhone(),
                'cep' => $this->getCep(),
                'road' => $this->getRoad(),
                'number' => $this->getNumber(),
                'city' => $this->getCity(),
                'state' => $this->getState(),
                'category' => $this->getCategory(),
                'registrationDate' => $this->getRegistrationDate(),
                'registrationComplete' => $this->getRegistrationComplete(),
            ];
    
            if($db->insert($data)){
                return true;
            }

            return false;

    }

    public function update(Db $db,int $id){
        $db->setTable($this->table);
        $data = [];
        
        if ($this->getLogo() !== '') {
            $data['logo'] = $this->getLogo();
        }
        if ($this->getName() !== '') {
            $data['name'] = $this->getName();
        }
        if ($this->getCnpj() !== '') {
            $data['cnpj'] = $this->getCnpj();
        }
        if ($this->getPhone() !== '') {
            $data['phone'] = $this->getPhone();
        }
        if ($this->getCep() !== '') {
            $data['cep'] = $this->getCep();
        }
        if ($this->getRoad() !== '') {
            $data['road'] = $this->getRoad();
        }
        if ($this->getNumber() !== '') {
            $data['number'] = $this->getNumber();
        }
        if ($this->getCity() !== '') {
            $data['city'] = $this->getCity();
        }
        if ($this->getState() !== '') {
            $data['state'] = $this->getState();
        }
        if ($this->getPlan() !== '') {
            $data['plan'] = $this->getPlan();
        }
        if ($this->getCategory() !== '') {
            $data['category'] = $this->getCategory();
        }
        if ($this->getRegistrationDate() !== '') {
            $data['registrationDate'] = $this->getRegistrationDate();
        }

        if ($this->getRegistrationComplete() !== 0) {
            $data['registrationComplete'] = $this->getRegistrationComplete();
        }

        if(!empty($data)){
            if($db->update("id={$id}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("id={$id}");
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

    public function getLogo(): string {
        return $this->logo;
    }

    public function setLogo(string $logo): void {
        $this->logo = $logo;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCnpj(): string {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): void {
        $this->cnpj = $cnpj;
    }

    public function getCep(): string {
        return $this->cep;
    }

    public function setCep(string $cep): void {
        $this->cep = $cep;
    }

    public function getRoad() {
        return $this->road;
    }

    public function setRoad($road) {
        $this->road = $road;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    public function getPlan(): string {
        return $this->plan;
    }

    public function setPlan(string $plan): void {
        $this->plan = $plan;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function setCategory(string $category): void {
        $this->category = $category;
    }

    public function getRegistrationDate(): string {
        return $this->registrationDate;
    }

    public function setRegistrationDate(string $registrationDate): void {
        $this->registrationDate = $registrationDate;
    }

    public function getRegistrationComplete(): int {
        return $this->registrationComplete;
    }

    public function setRegistrationComplete(int $registrationComplete): void {
        $this->registrationComplete = $registrationComplete;
    }

}

?>