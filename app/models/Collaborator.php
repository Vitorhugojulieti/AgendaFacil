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
    private string $registrationDate;
    private int $registrationComplete;
    private int $mainAdministrator;
    private array $services = [];
    private string $tableServices = "services";
    private string $tableSchedules = "schedules";
    private string $table = "collaborator";
    private string $tableServiceHasCollaborators = "collaborator_has_services";

    public function __construct($avatar = "", $name = "", $cpf = "", $phone = "", $email = "", $password = "", $nivel = "", $idCompany = 0, $registrationDate = "",$registrationComplete = 0,$mainAdministrator = 0){
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
    }

    public function totalRecords(Db $db){
        $db->setTable($this->table);
        $total = $db->totalRecords();
        return $total[0]['total'];
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $Collaborators = $db->query("*");
        $arrayObjectsCollaborator =[];

        foreach ($Collaborators as $collaborator){
            $newCollaborator = new Collaborator($collaborator['avatar'],$collaborator['name'],$collaborator['cpf'],$collaborator['phone'],$collaborator['email'],$collaborator['password'],$collaborator['nivel'],$collaborator['Company_idCompany'],$collaborator['registrationDate'],$collaborator['registrationComplete']);
            $newCollaborator->setId($collaborator['idCollaborator']);
            // $newCollaborator->services = $newCollaborator->getServices();
            array_push($arrayObjectsCollaborator,$newCollaborator);
        }
        
        return $arrayObjectsCollaborator;
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $collaboratorFound = $db->query("*","idCollaborator={$id}");

        if(!$collaboratorFound){
            return false;
        }

        $colllaboratorObject = new Collaborator($collaboratorFound[0]['avatar'],$collaboratorFound[0]['name'],$collaboratorFound[0]['cpf'],$collaboratorFound[0]['phone'],$collaboratorFound[0]['email'],$collaboratorFound[0]['password'],$collaboratorFound[0]['nivel'],$collaboratorFound[0]['Company_idCompany'],$collaboratorFound[0]['registrationDate'],$collaboratorFound[0]['registrationComplete']);
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

        $colllaboratorObject = new Collaborator($collaboratorFound[0]['avatar'],$collaboratorFound[0]['name'],$collaboratorFound[0]['cpf'],$collaboratorFound[0]['phone'],$collaboratorFound[0]['email'],$collaboratorFound[0]['password'],$collaboratorFound[0]['nivel'],$collaboratorFound[0]['Company_idCompany'],$collaboratorFound[0]['registrationDate'],$collaboratorFound[0]['registrationComplete']);
        $colllaboratorObject->setId($collaboratorFound[0]['idCollaborator'],);
        // $colllaboratorObject->services = $colllaboratorObject->getServices();
        return $colllaboratorObject;
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
                'registrationDate' => $this->getRegistrationDate(),
                'registrationComplete' => $this->getRegistrationComplete(),
                'mainAdministrator' => $this->getMainAdministrator(),
            ];
    
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
            $data['registrationDate'] = $this->getRegistrationDate();
        }

        if ($this->getRegistrationComplete() !== 0) {
            $data['registrationComplete'] = $this->getRegistrationComplete();
        }

        if ($this->getMainAdministrator() !== '') {
            $data['mainAdministrator'] = $this->getMainAdministrator();
        }

        if(!empty($data)){
            if($db->update("idCollaborator={$id}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idCollaborator={$id}");
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

    public function getMainAdministrator(): int {
        return $this->mainAdministrator;
    }

    public function setMainAdministrator(int $mainAdministrator): void {
        $this->mainAdministrator = $mainAdministrator;
    }
}

?>