<?php
namespace app\models;
use app\models\database\Db;
use app\models\CompanyHours;
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
    private array $hours = [];
    private array $images = [];
    private array $services = [];
    private string $table = "company";

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
                              ){

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
                               );

            $companyObject->setId($company['idCompany']);
            array_push($arrayObjectsCompany,$companyObject);
        }
        return $arrayObjectsCompany;
    }

    public function filterByLocationAndCategory(Db $db, String $city, String $uf, String $category = "", int $currentPage = 1, int $recordsPerPage = 10) {
        $db->setTable($this->table);
    
        $where = "city = '{$city}' AND state = '{$uf}'";
    
        if ($category != "") {
            $where .= " AND category = '{$category}'";
        }
    
        $paginationResult = $db->paginate($currentPage, $recordsPerPage, "*", $where);
        $companys = $paginationResult['data'];
        $arrayObjectsCompany = [];
    
        foreach ($companys as $company) {
            $companyObject = new Company(
                $company['logo'],
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
                $company['registrationComplete']
            );
    
            $companyObject->getServicesDb($db, $company['idCompany']);
            $companyObject->setId($company['idCompany']);
            $arrayObjectsCompany[] = $companyObject;
        }
    
        // Return the array of Company objects and pagination metadata
        return [
            'companys' => $arrayObjectsCompany,
            'pagination' => [
                'currentPage' => $paginationResult['currentPage'],
                'recordsPerPage' => $paginationResult['recordsPerPage'],
                'totalRecords' => $paginationResult['totalRecords'],
                'totalPages' => $paginationResult['totalPages']
            ]
        ];
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
                                    );

        $companyObject->setId($companyFound[0]['idCompany']);
        $companyObject->getOpeninghours($db,$id);
        $companyObject->getServicesDb($db,$id);
        $companyObject->getImagesDb($db,$id);
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
                                    );

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

    //TODO testar metodo
    public function isOpen(){
        //(1 = segunda-feira, 7 = domingo)
        $now = new \DateTime('2024-10-21 15:30:00');
        $now = $now->format('N');
        $open = false;

        foreach ($this->hours as $hour) {
            if($hour->getDayOfWeek() == $now){
                if(($now >= $hour->setOpeningHoursMorningStart()  && $now <= $hour->setOpeningHoursMorningEnd()) || ($now >= $hour->setOpeningHoursAfternoonStart()  && $now <= $hour->setOpeningHoursAfternoonEnd())){
                    $open = true;
                }
            }
        }
        return $open;
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

    public function getOpeninghours(Db $db, int $id){
        $hoursObject = new CompanyHours();
        $this->hours = $hoursObject->getByIdCompany($db,$id);
    }

    public function getArrayHours(): array{
        return $this->hours;
    }

    public function getImages(): array {
        return $this->images;
    }

    private function getImagesDb($db,$id){
        $imagesManager = new Images();
        $this->images = $imagesManager->getByCompany($db,$id);
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
    private function getServicesDb($db,$id): void {
        $serviceManager = new Service();
        $services = $serviceManager->getByCompany($db,$id);
        $this->services = $services['services'];
    }

    public function getHourByDay($day) {
        $hoursForDay = array_filter($this->hours, function($hour) use ($day) {
            return $hour->getDayOfWeek() == $day;
        });

        if ($hoursForDay) {
            if (!empty($hoursForDay)) {
                return array_values($hoursForDay)[0]; // Return the first hour
            }else{
                return false;
            }
        }
        return false; // Return false if no hours are found
    }
}

?>