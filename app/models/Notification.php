<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use JsonSerializable;

//TODO finalizar model notification
class Notification implements ModelInterface, JsonSerializable{
    private int $id;
    private int $idSender;
    private string $message;
    private string $link;
    private \DateTime $date;
    private int $notified;
    private int $idCompanyRecipient;
    private int $idUserRecipient;
    private string $table = "Notifications";

    public function __construct($idSender = 0, $message = "", $link = "",$date = new \DateTime(),$notified = 0,$idCompanyRecipient = 0, $idUserRecipient = 0){
        $this->idSender = $idSender;
        $this->message = $message;
        $this->link = $link;
        $this->date = $date;
        $this->notified = $notified;
        $this->idCompanyRecipient = $idCompanyRecipient;
        $this->idUserRecipient = $idUserRecipient;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
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

    public function getByUser(Db $db, int $idUsere){
        $db->setTable($this->table);
        $notifications = $db->query("*","idUserRecipient={$idCompany}");
        $arrayObjectsNotifications =[];
        foreach ($notifications as $notification){
            $notificationObj = new Notification($notification['idSender'],$notification['message'],$notification['link'],$notification['date'],$notification['notified'],$notification['idCompanyRecipient'],$notification['idUserRecipient']);
            $notificationObj->setId($notification['idNotification']);
            array_push($arrayObjectsNotifications,$notificationObj);
        }
        return $arrayObjectsNotifications;
    }

    public function getByCompany(Db $db, int $idCompany){
        $db->setTable($this->table);
        $notifications = $db->query("*","idCompanyRecipient={$idCompany}");
        $arrayObjectsNotifications =[];
        foreach ($notifications as $notification){
            $notificationObj = new Notification($notification['idSender'],$notification['message'],$notification['link'],new \DateTime($notification['date']),$notification['notified'],$notification['idCompanyRecipient'],$notification['idUserRecipient']);
            $notificationObj->setId($notification['idNotification']);
            array_push($arrayObjectsNotifications,$notificationObj);
        }
        return $arrayObjectsNotifications;
    }

    public function insert(Db $db){
        $db->setTable($this->table);
        $data = [
            'idCompanyRecipient' => $this->getIdCompanyRecipient(),
            'idUserRecipient' => $this->getIdUserRecipient(),
            'idSender' => $this->getIdSender(),
            'message' => $this->getMessage(),
            'link' => $this->getLink(),
            'date'=>$this->getDate(),
            'notified'=>$this->getNotified(),
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
        
        if ($this->getIdUserRecipient() !== 0) {
            $data['idUserRecipient'] = $this->getIdUserRecipient();
        }
        if ($this->getIdCompanyRecipient() !== 0) {
            $data['idCompanyRecipient'] = $this->getIdCompanyRecipient();
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
        // if ($this->getDate() !== 0) {
        //     $data['date'] = $this->getDate();
        // }
        if ($this->getNotified() !== 0) {
            $data['notified'] = $this->getNotified();
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

    function getIdUserRecipient(): int{
        return $this->idUserRecipient;
    }

    function setIdUserRecipient(int $idUserRecipient): void{
        $this->idUserRecipient = $idUserRecipient;
    }

    function getIdCompanyRecipient(): int{
        return $this->idCompanyRecipient;
    }

    function setIdCompanyRecipient(int $idCompanyRecipient): void{
        $this->idCompanyRecipient = $idCompanyRecipient;
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

    function getDate(): \DateTime{
        return $this->date;
    }

    function setDate(DateTime $date): void{
        $this->date = $date;
    }

    function getNotified(): int{
        return $this->notified;
    }

    function setNotified(int $notified): void{
        $this->notified = $notified;
    }
}

?>