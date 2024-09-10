<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use app\models\Schedule;
use JsonSerializable;

class Schedule implements ModelInterface, JsonSerializable{
    private int $id;
    private int $idClient;
    private int $idCompany;
    private int $paidOut;
    private float $totalPaid;
    private int $idVoucherService;
    private string $cancellationReason;
    private string $observation;
    private string $status;
    private \DateTime $startTime;
    private \DateTime $endTime;
    private \DateTime $dateSchedule;
    private array $collaborators;
    private array $services;
    // status -> 'confirmado' - 'aguardando pagamento' - 'cancelado'
    private string $tableServices = "schedules_has_services";
    private string $tableCollaborators = "Schedules_has_Collaborator";
    private string $table = "schedules";

    public function __construct($idClient = 0,$idCompany = 0, $paidOut = 0,$totalPaid = 0.00, $idVoucherService = 0, $cancellationReason = "", $observation = "",$status = "",$startTime = new \DateTime(),$endTime = new \DateTime(),$dateSchedule = new \DateTime()){
        $this->idClient = $idClient;
        $this->idCompany = $idCompany;
        $this->paidOut = $paidOut;
        $this->totalPaid = $totalPaid;
        $this->idVoucherService = (int) $idVoucherService;
        $this->cancellationReason = $cancellationReason;
        $this->observation = $observation;
        $this->status = $status;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->dateSchedule = $dateSchedule;
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
        $scheduleFound = $db->query("*","idSchedule={$id}");

        if(!$scheduleFound){
            return false;
        }
        $scheduleObj = new Schedule($scheduleFound[0]['Client_idClient'],$scheduleFound[0]['Company_idCompany'],$scheduleFound[0]['paidOut'],$scheduleFound[0]['totalPaid'],$scheduleFound[0]['voucherService'],$scheduleFound[0]['cancellationReason'],$scheduleFound[0]['observation'],$scheduleFound[0]['status'],new \DateTime($scheduleFound[0]['startTime']),new \DateTime($scheduleFound[0]['endTime']),new \DateTime($scheduleFound[0]['dateSchedule']));
        $scheduleObj->setId($scheduleFound[0]['idSchedule']);
        $scheduleObj->setCollaborators(Schedule::getCollaboratorsDb($db,$scheduleFound[0]['idSchedule']));
        $scheduleObj->setServices(Schedule::getServicesDb($db,$scheduleFound[0]['idSchedule']));
        return $scheduleObj;
    }

    public function getByDataTime(Db $db,$date,$startTime,$idCompany){
        $db->setTable($this->table);
        $scheduleFound = $db->query("*","dateSchedule='{$date->format('Y-m-d H:i:s')}' AND startTime='{$startTime->format('H:i:s')}' AND Company_idCompany = {$idCompany}");

        if(!$scheduleFound){
            return false;
        }
        // ($idClient = 0,$idCompany = 0, $paidOut = 0,$totalPaid = 0.00, $idVoucherService = 0,
        //  $cancellationReason = "", $observation = "
        // ",$status = "",$startTime = new \DateTime(),$endTime = new \DateTime(),$dateSchedule = new \DateTime()){
        $scheduleObj = new Schedule($scheduleFound[0]['Client_idClient'],
        $scheduleFound[0]['Company_idCompany'],
        $scheduleFound[0]['paidOut'],
        $scheduleFound[0]['totalPaid'],
        $scheduleFound[0]['voucherService'],
        $scheduleFound[0]['cancellationReason'],
        $scheduleFound[0]['observation'],
        $scheduleFound[0]['status'],
        new \DateTime($scheduleFound[0]['startTime']),
        new \DateTime($scheduleFound[0]['endTime']),
        new \DateTime($scheduleFound[0]['dateSchedule']));
        $scheduleObj->setId($scheduleFound[0]['idSchedule']);
        return $scheduleObj;
    }

    public function getByCompany(Db $db,$idCompany){
        $db->setTable($this->table);
        $schedules = $db->query("*","Company_idCompany={$idCompany}");
        $arrayObjectsSchedule =[];
        foreach ($schedules as $schedule){
            $scheduleObj = new Schedule($schedule['Client_idClient'],$schedule['Company_idCompany'],$schedule['paidOut'],$schedule['totalPaid'],$schedule['voucherService'],$schedule['cancellationReason'],$schedule['observation'],$schedule['status'],new \DateTime($schedule['startTime']),new \DateTime($schedule['endTime']),new \DateTime($schedule['dateSchedule']));
            $scheduleObj->setId($schedule['idSchedule']);
            array_push($arrayObjectsSchedule,$scheduleObj);
        }
        return $arrayObjectsSchedule;
    }

    public function getByClient(Db $db,$idClient){
        $db->setTable($this->table);
        $schedules = $db->query("*","Client_idClient={$idClient}");
        $arrayObjectsSchedule =[];
        foreach ($schedules as $schedule){
            $scheduleObj = new Schedule($schedule['Client_idClient'],$schedule['Company_idCompany'],$schedule['paidOut'],$schedule['totalPaid'],$schedule['voucherService'],$schedule['cancellationReason'],$schedule['observation'],$schedule['status'],new \DateTime($schedule['startTime']),new \DateTime($schedule['endTime']),new \DateTime($schedule['dateSchedule']));
            $scheduleObj->setId($schedule['idSchedule']);
            array_push($arrayObjectsSchedule,$scheduleObj);
        }
        return $arrayObjectsSchedule;
    }

    public function getByCollaborator(Db $db,$idCollaborator){
        $db->setTable("Schedules_has_Collaborator");
        $idsSchedules = $db->query("Schedules_idSchedule","Collaborator_idCollaborator={$idCollaborator}");
        $arrayObjectsSchedule =[];
        $db->setTable($this->table);
        $scheduleObj = new Schedule();
        foreach ($idsSchedules as $id) {
            $scheduleObj = $scheduleObj->getById($db,$id['Schedules_idSchedule']);
          
            array_push($arrayObjectsSchedule,$scheduleObj);
        }
        return $arrayObjectsSchedule;
    }

    public function getScheduledTimes($db,$day){
        $db->setTable($this->table);
        $times = $db->query("startTime,endTime"," DAY(dateSchedule)={$day}");
        return $times;
    }

    public function getScheduledDates($db){
        $db->setTable($this->table);
        $dates = $db->query("dateSchedule");
        return $dates;
    }

    public static function getServicesDb(Db $db, int $idSchedule){
        $db->setTable("schedules_has_services");
        $idServices = $db->query("Services_idService","Schedules_idSchedule={$idSchedule}");
        $serviceManager = new Service();
        $arrayObjectsService =[];
        foreach ($idServices as $id){
            $service = $serviceManager->getById($db,$id['Services_idService']);
            array_push($arrayObjectsService,$service);
        }
        return $arrayObjectsService;
    }

    public static function getCollaboratorsDb(Db $db, int $idSchedule){
        $db->setTable("Schedules_has_Collaborator");
        $idsCollaborators = $db->query("Collaborator_idCollaborator","Schedules_idSchedule={$idSchedule}");
        $collaboratorManager = new Collaborator();
        $arrayObjectsCollaborators =[];
        foreach ($idsCollaborators as $id){
            $collaborator = $collaboratorManager->getById($db,$id['Collaborator_idCollaborator']);
            array_push($arrayObjectsCollaborators,$collaborator);
        }
        return $arrayObjectsCollaborators;
    }

    public function getByCompanyForMonth(Db $db,int $idCompany,int $month){
        $db->setTable($this->table);
        $schedules = $db->query("*","Company_idCompany={$idCompany} AND MONTH(dateSchedule)={$month} AND status='confirmado'");
        $arrayObjectsSchedule =[];
        if(count($schedules) != 0){
            foreach ($schedules as $schedule){
                $scheduleObj = new Schedule($schedule['Client_idClient'],$schedule['Company_idCompany'],$schedule['paidOut'],$schedule['totalPaid'],$schedule['voucherService'],$schedule['cancellationReason'],$schedule['observation'],$schedule['status'],new \DateTime($schedule['startTime']),new \DateTime($schedule['endTime']),new \DateTime($schedule['dateSchedule']));
                $scheduleObj->setId($schedule['idSchedule']);
                array_push($arrayObjectsSchedule,$scheduleObj);
            }
        }
        return $arrayObjectsSchedule;
    }

    public function getByCompanyForMonthCancellations(Db $db,int $idCompany,int $month){
        $db->setTable($this->table);
        $schedules = $db->query("*","Company_idCompany={$idCompany} AND MONTH(dateSchedule)={$month} AND status='cancelado'");
        $arrayObjectsSchedule =[];
        if(count($schedules) != 0){
            foreach ($schedules as $schedule){
                $scheduleObj = new Schedule($schedule['Client_idClient'],$schedule['Company_idCompany'],$schedule['paidOut'],$schedule['totalPaid'],$schedule['voucherService'],$schedule['cancellationReason'],$schedule['observation'],$schedule['status'],new \DateTime($schedule['startTime']),new \DateTime($schedule['endTime']),new \DateTime($schedule['dateSchedule']));
                $scheduleObj->setId($schedule['idSchedule']);
                array_push($arrayObjectsSchedule,$scheduleObj);
            }
        }
        return $arrayObjectsSchedule;
    }
    
    public function getSchedulesByService(Db $db,int $idCompany,int $idService){
        $db->setTable($this->tableServices);
        $schedules = $db->totalRecords("Services_Company_idCompany={$idCompany} and Services_idService={$idService}");
        return $schedules[0]['total'];
    }

    public function getServicesScheduledsForMonth(Db $db,int $idCompany,int $month){
        $schedules = $this->getByCompanyForMonth($db,$idCompany,$month);
        $data = [];
        foreach ($schedules as $schedule) {
            $services = $this->getServicesDb($db,$schedule->getId());
            foreach ($services as $key => $service) {
                if(count($data)!= 0 ){
                    if(!in_array($service->getName(),$data[$key])){
                        array_push($data,['month'=>$month,'name'=>$service->getName(),'data'=>[$this->getSchedulesByService($db,$idCompany,$service->getId())]]);
                    }
                }else{
                    array_push($data,['month'=>$month,'name'=>$service->getName(),'data'=>[$this->getSchedulesByService($db,$idCompany,$service->getId())]]);
                }
            }
        }
        return $data;
    }

    public function getSchedulesForCollaboratorByCompany(Db $db,int $idCompany,int $idCollaborator){
        $db->setTable($this->tableCollaborators);
        $schedules = $db->totalRecords("Collaborator_Company_idCompany={$idCompany} and Collaborator_idCollaborator={$idCollaborator}");
        return $schedules[0]['total'];
        return $data;
    }

 

    public function insert(Db $db){
        $db->setTable($this->table);
        $data = [
            'paidOut' => $this->getPaidOut(),
            'totalPaid' => $this->getTotalPaid(),
            'Clientes_idCliente' => $this->getIdClient(),
            'Client_idClient' => $this->getIdClient(),
            'voucherService' => $this->getIdVoucherService(),
            'cancellationReason' => $this->getCancellationReason(),
            'observation'=>$this->getObservation(),
            'status'=>$this->getStatus(),
            'startTime'=>$this->getStartTime(),
            'endTime'=>$this->getEndTime(),
            'dateSchedule'=>$this->getDateSchedule(),
            'Company_idCompany'=>$this->getIdCompany(),
        ];
        $data = array_map(function($value) {
            return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
        }, $data);
      

        if ($db->insert($data)) {
            return true;
        }
        return false;
    }

    public static function insertScheduleHasServices($db,$idSchedule,$idService,$idCompany){
        $db->setTable("schedules_has_services");
        $data = [
            'Schedules_idSchedule' => $idSchedule,
            'Services_idService' => $idService,
            'Services_Company_idCompany' => $idCompany,
        ];
        if ($db->insert($data)) {
            return true;
        }
        return false;
    }

    public static function insertScheduleHasCollaborators($db,$idSchedule,$idCollaborator,$idCompany){
        $db->setTable("Schedules_has_Collaborator");
        $data = [
            'Schedules_idSchedule' => $idSchedule,
            'Collaborator_idCollaborator' => $idCollaborator,
            'Collaborator_Company_idCompany' => $idCompany,
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

    public function getIdClient(): int {
        return $this->idClient;
    }

    public function setIdClient(int $idClient): void {
        $this->idClient = $idClient;
    }

    public function getPaidOut(): int {
        return $this->paidOut;
    }

    public function setPaidOut(int $paidOut): void {
        $this->paidOut = $paidOut;
    }

    public function getTotalPaid(): float {
        return $this->totalPaid;
    }

    public function setTotalPaid(int $totalPaid): void {
        $this->totalPaid = $totalPaid;
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

    public function getDateSchedule(): \DateTime {
        return $this->dateSchedule;
    }

    public function setDateSchedule(\DateTime $dateSchedule): void {
        $this->dateSchedule = $dateSchedule;
    }

    public function getStartTime(): \DateTime {
        return $this->startTime;
    }

    public function setStartTime(\DateTime $startTime): void {
        $this->startTime = $startTime;
    }

    public function getEndTime(): \DateTime {
        return $this->endTime;
    }

    public function setEndTime(\DateTime $endTime): void {
        $this->endTime = $endTime;
    }

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function setServices(array $services): void {
        $this->services = $services;
    }

    public function getServices(): array {
        return $this->services;
    }

    public function setCollaborators(array $collaborators): void {
        $this->collaborators = $collaborators;
    }
    public function getCollaborators(): array {
        return $this->collaborators;
    }
}

?>