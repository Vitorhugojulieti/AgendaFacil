<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;

class Client implements ModelInterface{
    private int $id;
    private string $avatar;
    private string $name;
    private string $cpf;
    private string $phone;
    private string $email;
    private string $password;
    private string $registrationDate;

    public function __construct($avatar = "", $name = "", $cpf = "", $phone = "", $email = "", $password = "", $registrationDate = ""){
        $this->avatar = $avatar;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->registrationDate = $registrationDate;
    }

    public function getAll(Db $db){
        $clients = $db->query("*");
        $arrayObjectsClient =[];
        foreach ($clients as $client){
            $newClient = new Self($client['avatar'],$client['name'],$client['cpf'],$client['phone'],$client['email'],$client['password'],$client['registrationDate']);
            $newClient->setId($client['id']);
            array_push($arrayObjectsClient,$newClient);
        }
        return $arrayObjectsClient;
    }

    public function getById(Db $db, int $id){
        $clientFound = $db->query("*","id={$id}");

        if(!$clientFound){
            return "Cliente não encontrado";
        }

        $clientObject = new Self($clientFound[0]['avatar'],$clientFound[0]['name'],$clientFound[0]['cpf'],$clientFound[0]['phone'],$clientFound[0]['email'],$clientFound[0]['password'],$clientFound[0]['registrationDate']);
        $clientObject->setId($clientFound[0]['id'],);
        return $clientObject;
    }

    public function getByEmail(Db $db, $email){
        $clientFound = $db->query("*","email = '{$email}'");
        if(!$clientFound){
            return false;
        }
        $client = new Self($clientFound[0]['avatar'],$clientFound[0]['name'],$clientFound[0]['cpf'],$clientFound[0]['phone'],$clientFound[0]['email'],$clientFound[0]['password'],$clientFound[0]['registrationDate']);

        return $client;
    }

    public function emailHasPassword(Db $db,$email){
        $passwordFound = $db->query('password',"email = '{$email}'");
        if ($passwordFound && !empty($passwordFound[0]['password'])) {
            return true; 
        }

        return false;
    }

    public function cpfIsUsed(Db $db, $cpf){
        $cpfFound = $db->query('cpf',"cpf = '{$cpf}'");
        if(!$cpfFound){
            return false;
        }

        return true;
    }

    public function passwordIsUsed(Db $db, $password){
        $passwordFound = $db->query('password',"password = '{$password}'");
        if(!$passwordFound){
            return false;
        }

        return true;
    }

    public function insert(DB $db){
        
            $data = [
                'avatar' => $this->getAvatar(),
                'name' => $this->getName(),
                'cpf' => $this->getCpf(),
                'phone' => $this->getPhone(),
                'email' => $this->getEmail(),
                'password' => $this->getPassword(),
                'registrationDate' => $this->getRegistrationDate(),
            ];
    
            if($db->insert($data)){
                return true;
            }

            return false;

        // return "Não é possivel inserir data com campos vazios!";
    }

    public function update(Db $db,int $id){
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
        if ($this->getRegistrationDate() !== '') {
            $data['registrationDate'] = $this->getRegistrationDate();
        }

        if(!empty($data)){
            if($db->update("id={$id}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        return $db->delete("id={$id}");
    }

    private function hasEmptyAttribute(){
        return empty($this->getAvatar()) || empty($this->getName()) || empty($this->getCpf()) || empty($this->getPhone()) || empty($this->getEmail()) || empty($this->getPassword()) || empty($this->getRegistrationDate());
    }
    //getters and setters
    public function setId($id): void{
        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }

    public function setAvatar($avatar): void{
        $this->avatar = $avatar;
    }

    public function getAvatar(): string{
        return $this->avatar;
    }

    public function setName($name): void{
        $this->name = $name;
    }

    public function getName(): string{
        return $this->name;
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

    public function getRegistrationDate(): string {
        return $this->registrationDate;
    }

    public function setRegistrationDate(string $registrationDate): void {
        $this->registrationDate = $registrationDate;
    }
}

?>