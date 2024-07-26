<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;

class Schedule implements ModelInterface{
    private int $id;
    private int $idClient;
    private bool $paidOut;
    private int $idVoucherService;
    private string $cancellationReason;
    private string $observation;
    private string $status;
    private string $dateSchedule;
    // status -> 'confirmado' - 'aguardando pagamento' - 'cancelado'
    private string $tableServices = "schedules_has_services";
    private string $tableCollaborators = "Schedules_has_Collaborator";
    private string $table = "schedules";

    public function __construct($idClient = 0, $paidOut = false, $idVoucherService = 0, $cancellationReason = "", $observation = "",$status = ""){
        $this->idClient = $idClient;
        $this->paidOut = $paidOut;
        $this->idVoucherService = $idVoucherService;
        $this->cancellationReason = $cancellationReason;
        $this->observation = $observation;
        $this->status = $status;
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

    public function getScheduledTimes($db,$day){
        $db->setTable($this->table);
        $times = $db->query("startTime,endTime","dateSchedule={$day}");
        return $times;
    }

    public function getScheduledDates($db,$day){
        $db->setTable($this->table);
        $dates = $db->query("dateSchedule");
        return $dates;
    }

    public function insert(Db $db){
        $db->setTable($this->table);
        $data = [
            'Horarios_idHorario' => 1,
            'paidOut' => 0,
            'Clientes_idCliente' => 1,
            'voucherService' => 1,
            'cancellationReason' => "teste",
            'observation'=>"teste",
            'status'=>"cancelado",
        ];
        if ($db->insert($data)) {
            return true;
        }
        return false;
    }

    public function insertScheduleHasServices(){
        $db->setTable($this->tableServices);
        $data = [
            'Services_idService' => 0,
            'Services_Company_idCompany' => 1,
            'Schedules_Clientes_idCliente' => 1,
        ];
        if ($db->insert($data)) {
            return true;
        }
        return false;
    }

    public function insertScheduleHasCollaborators(){
        $db->setTable($this->tableCollaborators);
        $data = [
            'Schedules_idSchedule' => 0,
            'Collaborator_idCollaborator' => 1,
            'Collaborator_Company_idCompany' => 1,
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
    public function getIdClient(): int {
        return $this->idClient;
    }

    public function setIdClient(int $idClient): void {
        $this->idClient = $idClient;
    }

    public function getPaidOut(): bool {
        return $this->paidOut;
    }

    public function setPaidOut(bool $paidOut): void {
        $this->paidOut = $paidOut;
    }

    public function getIdVoucherService(): int {
        return $this->idVoucherService;
    }

    public function setIdVoucherService(int $idVoucherService): void {
        $this->idVoucherService = $idVoucherService;
    }

    public function getCancellationReason(): string {
        return $this->cancellationReason;
    }

    public function setCancellationReason(string $cancellationReason): void {
        $this->cancellationReason = $cancellationReason;
    }

    public function getObservation(): string {
        return $this->observation;
    }

    public function setObservation(string $observation): void {
        $this->observation = $observation;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getDateSchedule(): string {
        return $this->dateSchedule;
    }

    public function setDateSchedule(string $dateSchedule): void {
        $this->dateSchedule = $dateSchedule;
    }
}

?>