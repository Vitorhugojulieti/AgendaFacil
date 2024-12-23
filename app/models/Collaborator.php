<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use app\models\Service;
use app\models\Schedule;

class Collaborator implements ModelInterface{
    private int $id;
    private string $avatar;
    private string $name;
    private string $cpf;
    private string $phone;
    private string $email;
    private string $password;
    private string $nivel;
    private int $idCompany;
    private \DateTime $registrationDate;
    private int $registrationComplete;
    private int $mainAdministrator;
    private int $active;
    private float $commission;
    private array $services = [];
    private string $tableServices = "services";
    private string $tableSchedules = "schedules";
    private string $table = "collaborator";
    private string $tableServiceHasCollaborators = "collaborator_has_services";

    public function __construct($avatar = "", 
                                $name = "", 
                                $cpf = "", 
                                $phone = "", 
                                $email = "", 
                                $password = "", 
                                $nivel = "", 
                                $idCompany = 0, 
                                $registrationDate = new \DateTime(),
                                $registrationComplete = 0,
                                $mainAdministrator = 0,
                                $active = 1,
                                $commission = 0){

        $this->avatar = $avatar;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->nivel = $nivel;
        $this->idCompany = $idCompany;
        $this->registrationDate = $registrationDate;
        $this->registrationComplete = $registrationComplete;
        $this->mainAdministrator = $mainAdministrator;
        $this->active = $active;
        $this->commission = $commission;
    }

    public function totalRecords(Db $db){
        $db->setTable($this->table);
        $total = $db->totalRecords("Company_idCompany = {$this->getIdCompany()}");
        return $total[0]['total'];
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $Collaborators = $db->query("*");
        $arrayObjectsCollaborator =[];

        foreach ($Collaborators as $collaborator){
                                    $newCollaborator = new Collaborator($collaborator['avatar'],
                                    $collaborator['name'],
                                    $collaborator['cpf'],
                                    $collaborator['phone'],
                                    $collaborator['email'],
                                    $collaborator['password'],
                                    $collaborator['nivel'],
                                    $collaborator['Company_idCompany'],
                                    new \DateTime($collaborator['created_at']),
                                    $collaborator['registrationComplete'],
                                    $collaborator['mainAdministrator'],
                                    $collaborator['active'],
                                    floatval($collaborator['commission']));

            $newCollaborator->setId($collaborator['idCollaborator']);
            array_push($arrayObjectsCollaborator,$newCollaborator);
        }
        
        return $arrayObjectsCollaborator;
    }


    public function getCollaboratorsByFilters(Db $db, int $idCompany, string $status = "", string $nivel = "",int $currentPage = 1, int $recordsPerPage = 10) {
        $db->setTable($this->table);
        $where = "Company_idCompany = {$idCompany}";
    
        if ($status != "") {
            $where .= " AND active = {$status}";
        }

        if ($nivel != "") {
            $where .= " AND nivel = '{$nivel}'";
        }
    
        // Realiza a paginação com os filtros
        $paginationResult = $db->paginate($currentPage, $recordsPerPage, "*", $where);
        $Collaborators = $paginationResult['data'];
        $arrayObjectsCollaborator = [];
    
        foreach ($Collaborators as $collaborator){
            $newCollaborator = new Collaborator($collaborator['avatar'],
                                                $collaborator['name'],
                                                $collaborator['cpf'],
                                                $collaborator['phone'],
                                                $collaborator['email'],
                                                $collaborator['password'],
                                                $collaborator['nivel'],
                                                $collaborator['Company_idCompany'],
                                                new \DateTime($collaborator['created_at']),
                                                $collaborator['registrationComplete'],
                                                $collaborator['mainAdministrator'],
                                                $collaborator['active'],
                                                floatval($collaborator['commission']));

            $newCollaborator->setId($collaborator['idCollaborator']);
            array_push($arrayObjectsCollaborator,$newCollaborator);
        }
        
        return [
            'collaborators' => $arrayObjectsCollaborator,
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
        $collaboratorFound = $db->query("*","idCollaborator={$id}");

        if(!$collaboratorFound){
            return false;
        }

        $colllaboratorObject = new Collaborator($collaboratorFound[0]['avatar'],
                                                $collaboratorFound[0]['name'],
                                                $collaboratorFound[0]['cpf'],
                                                $collaboratorFound[0]['phone'],
                                                $collaboratorFound[0]['email'],
                                                $collaboratorFound[0]['password'],
                                                $collaboratorFound[0]['nivel'],
                                                $collaboratorFound[0]['Company_idCompany'],
                                                new \DateTime($collaboratorFound[0]['created_at']),
                                                $collaboratorFound[0]['registrationComplete'],
                                                $collaboratorFound[0]['mainAdministrator'],
                                                $collaboratorFound[0]['active'],
                                                floatval($collaboratorFound[0]['commission']));

        $colllaboratorObject->setId($collaboratorFound[0]['idCollaborator'],);
        // $colllaboratorObject->services = $colllaboratorObject->getServices();
        return $colllaboratorObject;
    }

    public function getByEmail(Db $db, string $email){
        $db->setTable($this->table);
        $collaboratorFound = $db->query("*","email='{$email}'");

        if(!$collaboratorFound){
            return false;
        }

        $colllaboratorObject = new Collaborator($collaboratorFound[0]['avatar'],
                                                $collaboratorFound[0]['name'],
                                                $collaboratorFound[0]['cpf'],
                                                $collaboratorFound[0]['phone'],
                                                $collaboratorFound[0]['email'],
                                                $collaboratorFound[0]['password'],
                                                $collaboratorFound[0]['nivel'],
                                                $collaboratorFound[0]['Company_idCompany'],
                                                new \DateTime($collaboratorFound[0]['created_at']),
                                                $collaboratorFound[0]['registrationComplete'],
                                                $collaboratorFound[0]['mainAdministrator'],
                                                $collaboratorFound[0]['active'],
                                                floatval($collaboratorFound[0]['commission']));
                                                
        $colllaboratorObject->setId($collaboratorFound[0]['idCollaborator'],);
        // $colllaboratorObject->services = $colllaboratorObject->getServices();
        return $colllaboratorObject;
    }

    public function getByCompany(Db $db,$idCompany, int $currentPage = 1, int $recordsPerPage = 10){
        $db->setTable($this->table);
        $where = "Company_idCompany = {$idCompany}";
        $paginationResult= $db->paginate($currentPage, $recordsPerPage, "*", $where);
        $Collaborators = $paginationResult['data'];
        $arrayObjectsCollaborator =[];

        foreach ($Collaborators as $collaborator){
            $newCollaborator = new Collaborator($collaborator['avatar'],
                                                $collaborator['name'],
                                                $collaborator['cpf'],
                                                $collaborator['phone'],
                                                $collaborator['email'],
                                                $collaborator['password'],
                                                $collaborator['nivel'],
                                                $collaborator['Company_idCompany'],
                                                new \DateTime($collaborator['created_at']),
                                                $collaborator['registrationComplete'],
                                                $collaborator['mainAdministrator'],
                                                $collaborator['active'],
                                                floatval($collaborator['commission']));

            $newCollaborator->setId($collaborator['idCollaborator']);
            // $newCollaborator->services = $newCollaborator->getServices();
            array_push($arrayObjectsCollaborator,$newCollaborator);
        }
        
        return [
            'collaborators' => $arrayObjectsCollaborator,
            'pagination' => [
                'currentPage' => $paginationResult['currentPage'],
                'recordsPerPage' => $paginationResult['recordsPerPage'],
                'totalRecords' => $paginationResult['totalRecords'],
                'totalPages' => $paginationResult['totalPages']
            ]
        ];
    }

    public function setServices(array $services){
        $this->services = $services;
    }

   
    public function getServices(Db $db){
        $db->setTable($this->tableServiceHasCollaborators);
        $idServices = $db->query("Services_idService","Collaborator_idCollaborator={$this->getId()} AND Collaborator_Company_idCompany={$this->getIdCompany()}");
        $arrayServices =[];
        foreach ($idServices as $idService){
            array_push($arrayServices,$idService['Services_idService']);
        }
        return $arrayServices;
    }

    public function getSchedules(){
        $db->setTable($this->tableSchedules);
        
        $schedules = new Schedule();
        $schedules = $schedules->getByIdCollaborator($this->getId());

        return $schedules;
    }

    public function insert(DB $db){
        $db->setTable($this->table);
        
            $data = [
                'avatar' => $this->getAvatar(),
                'name' => $this->getName(),
                'cpf' => $this->getCpf(),
                'phone' => $this->getPhone(),
                'email' => $this->getEmail(),
                'password' => $this->getPassword(),
                'nivel' => $this->getNivel(),
                'Company_idCompany' => $this->getIdCompany(),
                'registrationComplete' => $this->getRegistrationComplete(),
                'mainAdministrator' => $this->getMainAdministrator(),
                'active' => $this->getActive(),
                'commission' => $this->getCommission(),
            ];
    
            $data = array_map(function($value) {
                return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
            }, $data);
            
            if($db->insert($data)){
                return true;
            }

            return false;
    }

    public function insertCollaboratorHasService(Db $db,$idService,$idCollaborator,$idCompany){
        $db->setTable($this->tableServiceHasCollaborators);
        
        $data = [
            'Collaborator_idCollaborator' => $idCollaborator,
            'Collaborator_Company_idCompany' => $idCompany,
            'Services_idService' => $idService,
        ];

        if($db->insert($data)){
            return true;
        }

        return false;
    }

    public function updateCollaboratorHasService(Db $db,$idService,$idCollaborator,$idCompany){
        $db->setTable($this->tableServiceHasCollaborators);
        
        $data = [
            'Collaborator_idCollaborator' => $idCollaborator,
            'Collaborator_Company_idCompany' => $idCompany,
            'Services_idService' => $idService,
            'Services_Company_idCompany' => $idCompany,
        ];

        if($db->insert($data)){
            return true;
        }

        return false;
    }

    public function update(Db $db,int $id){
        $db->setTable($this->table);
        $data = [];
        
        if ($this->getAvatar() !== '') {
            $data['avatar'] = $this->getAvatar();
        }
        if ($this->getName() !== '') {
            $data['name'] = $this->getName();
        }
        if ($this->getCpf() !== '') {
            $data['cpf'] = $this->getCpf();
        }
        if ($this->getPhone() !== '') {
            $data['phone'] = $this->getPhone();
        }
        if ($this->getEmail() !== '') {
            $data['email'] = $this->getEmail();
        }
        if ($this->getPassword() !== '') {
            $data['password'] = $this->getPassword();
        }
        if ($this->getNivel() !== '') {
            $data['nivel'] = $this->getNivel();
        }
        if ($this->getIdCompany() !== '') {
            $data['Company_idCompany'] = $this->getIdCompany();
        }
        if ($this->getRegistrationDate() !== '') {
            $data['created_at'] = $this->getRegistrationDate();
        }

        if ($this->getRegistrationComplete() !== 0) {
            $data['registrationComplete'] = $this->getRegistrationComplete();
        }

        if ($this->getMainAdministrator() !== '') {
            $data['mainAdministrator'] = $this->getMainAdministrator();
        }

        if ($this->getActive() !== '') {
            $data['active'] = $this->getActive();
        }

        if ($this->getCommission() !== '') {
            $data['commission'] = $this->getCommission();
        }
        $data = array_map(function($value) {
            return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
        }, $data);

        if(!empty($data)){
            if($db->update("idCollaborator={$id} AND Company_idCompany={$this->getIdCompany()}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idCollaborator={$id} AND Company_idCompany={$this->getIdCompany()}");
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

    public function getAvatar(): string {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void {
        $this->avatar = $avatar;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void {
        $this->cpf = $cpf;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getNivel(): string {
        return $this->nivel;
    }

    public function setNivel(string $nivel): void {
        $this->nivel = $nivel;
    }

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function getRegistrationDate(): \DateTime {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTime $registrationDate): void {
        $this->registrationDate = $registrationDate;
    }

    public function getRegistrationComplete(): int {
        return $this->registrationComplete;
    }

    public function setRegistrationComplete(int $registrationComplete): void {
        $this->registrationComplete = $registrationComplete;
    }

    public function getMainAdministrator(): int {
        return $this->mainAdministrator;
    }

    public function setMainAdministrator(int $mainAdministrator): void {
        $this->mainAdministrator = $mainAdministrator;
    }

    public function getActive(): int {
        return $this->active;
    }

    public function setActive(int $active): void {
        $this->active = $active;
    }

    public function getCommission(): float {
        return $this->commission;
    }

    public function setCommission(float $commission): void {
        $this->commission = $commission;
    }


    public function collaboratorIsUsed(){
        $db = new Db();
        $db->connect();
        $db->setTable('collaborator_has_services');
        $usedInServices = $db->query("Collaborator_idCollaborator","Collaborator_idCollaborator={$this->getId()}");
        $db->setTable('schedule_orders');
        $usedInSchedules = $db->query("collaborator_idCollaborator","collaborator_idCollaborator={$this->getId()}");

        if(count($usedInSchedules) > 0 || count($usedInServices) > 0 ){
            return true;
        }else{
            return 0;
        }
    }
}

?>