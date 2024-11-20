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
    private int $registrationComplete;
    private string $table;

    public function __construct($avatar = "",
                               $name = "",
                                $cpf = "",
                                $phone = "",
                                $email = "",
                                $password = "",
                                $registrationDate = "",
                                $registrationComplete = 0){
        $this->avatar = $avatar;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->registrationDate = $registrationDate;
        $this->registrationComplete = $registrationComplete;
        $this->table = "client";
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $clients = $db->query("*");
        $arrayObjectsClient =[];
        foreach ($clients as $client){
            $newClient = new Client($client['avatar'],$client['name'],$client['cpf'],$client['phone'],$client['email'],$client['password'],$client['created_at '],$client['registrationComplete']);
            $newClient->setId($client['idClient']);
            array_push($arrayObjectsClient,$newClient);
        }
        return $arrayObjectsClient;
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $clientFound = $db->query("*","idClient={$id}");

        if(!$clientFound){
            return false;
        }

        $clientObject = new Client($clientFound[0]['avatar'],$clientFound[0]['name'],$clientFound[0]['cpf'],$clientFound[0]['phone'],$clientFound[0]['email'],$clientFound[0]['password'],$clientFound[0]['created_at'],$clientFound[0]['registrationComplete']);
        $clientObject->setId($clientFound[0]['idClient'],);
        return $clientObject;
    }

    public function getByEmail(Db $db, $email){
        $db->setTable($this->table);
        $clientFound = $db->query("*","email = '{$email}'");
        if(!$clientFound){
            return false;
        }
        $client = new Client($clientFound[0]['avatar'],$clientFound[0]['name'],$clientFound[0]['cpf'],$clientFound[0]['phone'],$clientFound[0]['email'],$clientFound[0]['password'],$clientFound[0]['created_at'],$clientFound[0]['registrationComplete']);
        $client->setId($clientFound[0]['idClient']);

        return $client;
    }

    public function emailHasPassword(Db $db,$email){
        $db->setTable($this->table);
        $passwordFound = $db->query('password',"email = '{$email}'");
        if ($passwordFound && !empty($passwordFound[0]['password'])) {
            return true; 
        }

        return false;
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

        if ($this->getRegistrationComplete() !== 0) {
            $data['registrationComplete'] = $this->getRegistrationComplete();
        }

        if(!empty($data)){
            if($db->update("idClient={$id}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idClient={$id}");
    }

    public function removeAttribute($attribute) {
        if (property_exists($this, $attribute)) {
            unset($this->$attribute);
        }
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

    public function getRegistrationComplete(): int {
        return $this->registrationComplete;
    }

    public function setRegistrationComplete(int $registrationComplete): void {
        $this->registrationComplete = $registrationComplete;
    }

    public function getDefaultClient(){
        $clientDefault = new Client(AVATAR_DEFAULT,
                                    'Colaborador padrão',
                                    'xxx.xxx.xxx',
                                    '(xx)xxxxx-xxxx',
                                    'xxxxx@xxx.com',
                                    'xxxxxxxxxxxxxxx',
                                    '',1);
        $clientDefault->setId(0);
        return $clientDefault;
    }

}

?>