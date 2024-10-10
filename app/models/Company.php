<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use JsonSerializable;

class Company implements ModelInterface, JsonSerializable{
    private int $id;
    private string $logo;
    private string $name;
    private string $cnpj;
    private string $phone;
    private string $cep;
    private string $road;
    private string $number;
    private string $district;
    private string $city;
    private string $state;
    private string $plan;
    private string $category;
    private string $registrationDate;
    private int $registrationComplete;
    private \DateTime $openingHoursMorningStart;
    private \DateTime $openingHoursMorningEnd;
    private \DateTime $openingHoursAfternoonStart;
    private \DateTime $openingHoursAfternoonEnd;
    private array $images = [];
    private array $services = [];
    private string $table = "company";
    private string $tableServices = "services";

    public function __construct($logo = "",
                                $name = "",
                                $cnpj = "",
                                $phone = "", 
                                $category = "", 
                                $cep = "", 
                                $road = "",
                                $number = "",
                                $district = "",
                                $state = "",
                                $city = "", 
                                $plan = "", 
                                $registrationDate = "",
                                $registrationComplete = 0,
                                $openingHoursMorningStart = new \DateTime(),
                                $openingHoursMorningEnd = new \DateTime(),
                                $openingHoursAfternoonStart = new \DateTime(),
                                $openingHoursAfternoonEnd = new \DateTime()){

        $this->logo = $logo;
        $this->name = $name;
        $this->cnpj = $cnpj;
        $this->phone = $phone;
        $this->cep = $cep;
        $this->road = $road;
        $this->city = $city;
        $this->state = $state;
        $this->number = $number;
        $this->district = $district;
        $this->plan = $plan;
        $this->category = $category;
        $this->registrationDate = $registrationDate;
        $this->registrationComplete = $registrationComplete;
        $this->openingHoursMorningStart = $openingHoursMorningStart;
        $this->openingHoursMorningEnd = $openingHoursMorningEnd;
        $this->openingHoursAfternoonStart = $openingHoursAfternoonStart;
        $this->openingHoursAfternoonEnd = $openingHoursAfternoonEnd;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $companys = $db->query("*");
        $arrayObjectsCompany =[];
        foreach ($companys as $company){
            $companyObject = new Company($company['logo'],
                                $company['name'],
                                $company['cnpj'],
                                $company['phone'],
                                $company['category'],
                                $company['cep'],
                                $company['road'],
                                $company['number'],
                                $company['district'],
                                $company['state'],
                                $company['city'],
                                $company['plan'],
                                $company['created_at'],
                                $company['registrationComplete'],
                                new \DateTime($company['openingHoursMorningStart']),
                                new \DateTime($company['openingHoursMorningEnd']),
                                new \DateTime($company['openingHoursAfternoonStart']),
                                new \DateTime($company['openingHoursAfternoonEnd']));

            $companyObject->setId($company['idCompany']);
            array_push($arrayObjectsCompany,$companyObject);
        }
        return $arrayObjectsCompany;
    }

    public function getByLocation(Db $db, String $city,String $uf){
        $db->setTable($this->table);
        $companys = $db->query("*","city='{$city}' AND state='{$uf}'");
        $arrayObjectsCompany =[];
        foreach ($companys as $company){
            $companyObject = new Company($company['logo'],
                                        $company['name'],
                                        $company['cnpj'],
                                        $company['phone'],
                                        $company['category'],
                                        $company['cep'],
                                        $company['road'],
                                        $company['number'],
                                        $company['district'],
                                        $company['state'],
                                        $company['city'],
                                        $company['plan'],
                                        $company['created_at'],
                                        $company['registrationComplete'],
                                        new \DateTime($company['openingHoursMorningStart']),
                                        new \DateTime($company['openingHoursMorningEnd']),
                                        new \DateTime($company['openingHoursAfternoonStart']),
                                        new \DateTime($company['openingHoursAfternoonEnd']));

            $companyObject->setId($company['idCompany']);
            array_push($arrayObjectsCompany,$companyObject);
        }
        return $arrayObjectsCompany;
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $companyFound = $db->query("*","idCompany={$id}");

        if(!$companyFound){
            return false;
        }
        $companyObject = new Company($companyFound[0]['logo'],
                                    $companyFound[0]['name'],
                                    $companyFound[0]['cnpj'],
                                    $companyFound[0]['phone'],
                                    $companyFound[0]['category'],
                                    $companyFound[0]['cep'],
                                    $companyFound[0]['road'],
                                    $companyFound[0]['number'],
                                    $companyFound[0]['district'],
                                    $companyFound[0]['state'],
                                    $companyFound[0]['city'],
                                    $companyFound[0]['plan'],
                                    $companyFound[0]['created_at'],
                                    $companyFound[0]['registrationComplete'],
                                    new \DateTime($companyFound[0]['openingHoursMorningStart']),
                                    new \DateTime($companyFound[0]['openingHoursMorningEnd']),
                                    new \DateTime($companyFound[0]['openingHoursAfternoonStart']),
                                    new \DateTime($companyFound[0]['openingHoursAfternoonEnd']));

        $companyObject->setId($companyFound[0]['idCompany']);
        
        // get images for company
        $imagesManager = new Images();
        $companyObject->setImages($imagesManager->getByCompany($db,$companyFound[0]['idCompany']));
        //get services for company
        $serviceManager = new Service();
        $companyObject->setServices($serviceManager->getByCompany($db,$companyFound[0]['idCompany']));
        return $companyObject;
    }

    public function getByCnpj(Db $db, string $cnpj){
        $db->setTable($this->table);
        $companyFound = $db->query("*","cnpj='{$cnpj}'");
        if(!$companyFound){
            return false;
        }
        $companyObject = new Company($companyFound[0]['logo'],
                                    $companyFound[0]['name'],
                                    $companyFound[0]['cnpj'],
                                    $companyFound[0]['phone'],
                                    $companyFound[0]['category'],
                                    $companyFound[0]['cep'],
                                    $companyFound[0]['road'],
                                    $companyFound[0]['number'],
                                    $companyFound[0]['district'],
                                    $companyFound[0]['state'],
                                    $companyFound[0]['city'],
                                    $companyFound[0]['plan'],
                                    $companyFound[0]['created_at'],
                                    $companyFound[0]['registrationComplete'],
                                    new \DateTime($companyFound[0]['openingHoursMorningStart']),
                                    new \DateTime($companyFound[0]['openingHoursMorningEnd']),
                                    new \DateTime($companyFound[0]['openingHoursAfternoonStart']),
                                    new \DateTime($companyFound[0]['openingHoursAfternoonEnd']));

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
                'district' => $this->getDistrict(),
                'city' => $this->getCity(),
                'state' => $this->getState(),
                'category' => $this->getCategory(),
                'registrationComplete' => $this->getRegistrationComplete(),
                'openingHoursMorningStart' => $this->getOpeningHoursMorningStart(),
                'openingHoursMorningEnd' => $this->getOpeningHoursMorningEnd(),
                'openingHoursAfternoonStart' => $this->getOpeningHoursAfternoonStart(),
                'openingHoursAfternoonEnd' => $this->getOpeningHoursAfternoonEnd(),
            ];
    
            $data = array_map(function($value) {
                return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
            }, $data);
            
            if ($db->insert($data)) {
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
        if ($this->getDistrict() !== '') {
            $data['district'] = $this->getDistrict();
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
            $data['created_at'] = $this->getRegistrationDate();
        }

        if ($this->getRegistrationComplete() !== 0) {
            $data['registrationComplete'] = $this->getRegistrationComplete();
        }

        if ($this->getOpeningHoursMorningStart() != '') {
            $data['openingHoursMorningStart'] = $this->getOpeningHoursMorningStart();
        }

        if ($this->getOpeningHoursMorningEnd() != '') {
            $data['openingHoursMorningEnd'] = $this->getOpeningHoursMorningEnd();
        }

        if ($this->getOpeningHoursAfternoonStart() != '') {
            $data['openingHoursAfternoonStart'] = $this->getOpeningHoursAfternoonStart();
        }

        if ($this->getOpeningHoursAfternoonEnd() != '') {
            $data['openingHoursAfternoonEnd'] = $this->getOpeningHoursAfternoonEnd();
        }

        $data = array_map(function($value) {
            return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
        }, $data);

        if(!empty($data)){
            if($db->update("idCompany={$id}",$data)){
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

    public function getDistrict() {
        return $this->district;
    }

    public function setDistrict($district) {
        $this->district = $district;
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

    public function setOpeningHoursMorningStart(\DateTime $openingHoursMorningStart): void {
        $this->openingHoursMorningStart = $openingHoursMorningStart;
    }

    public function getOpeningHoursMorningStart(): \DateTime {
        return $this->openingHoursMorningStart;
    }

    public function setOpeningHoursMorningEnd(\DateTime $openingHoursMorningEnd): void {
        $this->openingHoursMorningEnd = $openingHoursMorningEnd;
    }

    public function getOpeningHoursMorningEnd(): \DateTime {
        return $this->openingHoursMorningEnd;
    }
    
    public function getOpeningHoursAfternoonStart(): \DateTime {
        return $this->openingHoursAfternoonStart;
    }

    public function setOpeningHoursAfternoonStart(\DateTime $openingHoursAfternoonStart): void {
        $this->openingHoursAfternoonStart = $openingHoursAfternoonStart;
    }

    public function getOpeningHoursAfternoonEnd(): \DateTime {
        return $this->openingHoursAfternoonEnd;
    }

    public function setOpeningHoursAfternoonEnd(\DateTime $openingHoursAfternoonEnd): void {
        $this->openingHoursAfternoonEnd = $openingHoursAfternoonEnd;
    }

    public function getImages(): array {
        return $this->images;
    }

    public function setImages(array $images): void {
        $this->images = $images;
    }
    public function setServices(array $services): void {
        $this->services = $services;
    }
    public function getServices(): array {
        return $this->services;
    }
}

?>