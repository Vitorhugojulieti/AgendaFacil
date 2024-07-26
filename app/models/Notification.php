<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;

class Notification implements ModelInterface{
    private int $id;
    private int $idRecipient;
    private int $idSender;
    private string $message;
    private string $link;
    private string $typeNotification;
    private string $date;
    private string $table = "notifications";

    public function __construct($idRecipient = 0, $idSender = 0, $message = "", $link = "", $typeNotification = "",$date = ""){
        $this->idRecipient = $idRecipient;
        $this->idSender = $idSender;
        $this->message = $message;
        $this->link = $link;
        $this->typeNotification = $typeNotification;
        $this->date = $date;
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $notifications = $db->query("*");
        $arrayObjectsNotifications =[];
        foreach ($notifications as $notification){
            $notificationObj = new Notification($notification['idRecipient'],$notification['idSender'],$notification['message'],$notification['link'],$notification['typeNotification'],$notification['date']);
            $notificationObj->setId($notification['idNotification']);
            array_push($arrayObjectsNotifications,$notificationObj);
        }
        return $arrayObjectsNotifications;
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $notificationFound = $db->query("*","idNotification={$id}");

        if(!$notificationFound){
            return false;
        }

        $notificationObject = new Notification($notificationFound[0]['idRecipient'],$notificationFound[0]['idSender'],$notificationFound[0]['message'],$notificationFound[0]['link'],$notificationFound[0]['typeNotification'],$notificationFound[0]['date']);
        $notificationObject->setId($notificationFound[0]['idNotification'],);
        return $notificationObject;
    }

    public function insert(Db $db){
        $db->setTable($this->table);
        $data = [
            'idRecipient' => $this->getIdRecipient(),
            'idSender' => $this->getIdSender(),
            'message' => $this->getMessage(),
            'link' => $this->getLink(),
            'typeNotification'=>$this->getTypeNotification(),
            'date'=>$this->getDate(),
        ];
        if ($db->insert($data)) {
            return true;
        }
        return false;
    }

    public function update(Db $db,int $id){
        $db->setTable($this->table);
        $data = [];
        
        if ($this->getIdRecipient() !== 0) {
            $data['idRecipient'] = $this->getIdRecipient();
        }
        if ($this->getIdSender() !== 0) {
            $data['idSender'] = $this->getIdSender();
        }
        if ($this->getMessage() !== '') {
            $data['message'] = $this->getMessage();
        }
        if ($this->getLink() !== 0) {
            $data['link'] = $this->getLink();
        }
        if ($this->getTypeNotification() !== 0) {
            $data['typeNotification'] = $this->getTypeNotification();
        }
        if ($this->getDate() !== 0) {
            $data['date'] = $this->getDate();
        }
       
        if(!empty($data)){
            if($db->update("idNotification={$id}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idNotification={$id}");
    }

    //getters and setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    function getIdRecipient(): int{
        return $this->idRecipient;
    }

    function setIdRecipient(int $idRecipient): void{
        $this->idRecipient = $idRecipient;
    }

    function getIdSender(): int{
        return $this->idSender;
    }

    function setIdSender(int $idSender): void{
        $this->idSender = $idSender;
    }

    function getMessage(): string{
        return $this->message;
    }

    function setMessage(string $message): void{
        $this->message = $message;
    }

    function getLink(): string{
        return $this->link;
    }

    function setLink(string $link): void{
        $this->link = $link;
    }

    function getTypeNotification(): string{
        return $this->typeNotification;
    }

    function setTypeNotification(string $typeNotification): void{
        $this->typeNotification = $typeNotification;
    }

    function getDate(): string{
        return $this->date;
    }

    function setDate(string $date): void{
        $this->date = $date;
    }
}

?>