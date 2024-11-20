<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use app\models\Schedule;
use app\models\Client;
use JsonSerializable;

class Schedule implements ModelInterface, JsonSerializable{
    private int $id;
    private int $idClient;
    private int $idCompany;
    private int $paidOut;
    private float $totalPaid;
    private int $idVoucherService;
    private string $cancellationReason;
    private string $cancellationDescription;
    private string $observation;
    private string $status;
    private \DateTime $startTime;
    private \DateTime $endTime;
    private \DateTime $dateSchedule;
    private \DateTime $registrationDate;
    private array $collaborators;
    private array $services;
    private Client $client;
    // status -> 'confirmado' - 'aguardando pagamento' - 'cancelado'
    private string $tableOrders = "schedule_orders";
    private string $table = "schedules";

    public function __construct($idClient = 0,
                                $idCompany = 0,
                                $paidOut = 0,
                                $totalPaid = 0.00,
                                $idVoucherService = 0,
                                $cancellationReason = "",
                                $observation = "",
                                $status = "",
                                $startTime = new \DateTime(),
                                $endTime = new \DateTime(),
                                $dateSchedule = new \DateTime(),
                                $registrationDate = new \DateTime(),
                                $cancellationDescription = ""){

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
        $this->registrationDate = $registrationDate;
        $this->cancellationDescription = $cancellationDescription;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function getAll(Db $db){
   
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $scheduleFound = $db->query("*","idSchedule={$id}");

        if(!$scheduleFound){
            return false;
        }
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
                                                new \DateTime($scheduleFound[0]['dateSchedule']),
                                                new \DateTime($scheduleFound[0]['created_at']),
                                                $scheduleFound[0]['cancellationDescripton'] == null ? '' : $scheduleFound[0]['cancellationDescripton']);

        $scheduleObj->setId($scheduleFound[0]['idSchedule']);
        $scheduleObj->setCollaborators(Schedule::getCollaboratorsDb($db,$scheduleFound[0]['idSchedule']));
        $scheduleObj->setServices(Schedule::getServicesDb($db,$scheduleFound[0]['idSchedule']));
        return $scheduleObj;
    }

    public function getByDataTime(Db $db,$date,$startTime,$idCompany){
        $db->setTable($this->table);
        $scheduleFound = $db->query("*","dateSchedule='{$date->format('Y-m-d')}' AND startTime='{$startTime->format('H:i:s')}' AND Company_idCompany = {$idCompany}");

        if(!$scheduleFound){
            return false;
        }
       
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
                                    new \DateTime($scheduleFound[0]['dateSchedule']),
                                    new \DateTime($scheduleFound[0]['created_at']),
                                    $scheduleFound[0]['cancellationDescripton']);

        $scheduleObj->setId($scheduleFound[0]['idSchedule']);
        return $scheduleObj;
    }

    public function getByCompany(Db $db,$idCompany){
        $db->setTable($this->table);
        $schedules = $db->query("*","Company_idCompany={$idCompany}");
        $arrayObjectsSchedule =[];
        foreach ($schedules as $schedule){
            $scheduleObj = new Schedule($schedule['Client_idClient'],
                                        $schedule['Company_idCompany'],
                                        $schedule['paidOut'],
                                        $schedule['totalPaid'],
                                        $schedule['voucherService'],
                                        $schedule['cancellationReason'],
                                        $schedule['observation'],
                                        $schedule['status'],
                                        new \DateTime($schedule['startTime']),
                                        new \DateTime($schedule['endTime']),
                                        new \DateTime($schedule['dateSchedule']),
                                        new \DateTime($schedule['created_at']),
                                        $schedule['cancellationDescripton'] == null ? '' : $schedule['cancellationDescripton']);

            $scheduleObj->setId($schedule['idSchedule']);
            $client = new Client(); 
            $client = $client->getById($db,$schedule['Client_idClient']);
            $scheduleObj->setClient($client);
            array_push($arrayObjectsSchedule,$scheduleObj);
        }
        return $arrayObjectsSchedule;
    }

    public function getByCompanyForDate(Db $db,$idCompany,$startDate,$endDate){
        $db->setTable($this->table);
        $schedules = $db->query("*","Company_idCompany={$idCompany} AND dateSchedule>='{$startDate->format('Y-m-d H:i:s')}' AND dateSchedule<='{$endDate->format('Y-m-d H:i:s')}'");
        $arrayObjectsSchedule =[];
        foreach ($schedules as $schedule){
            $scheduleObj = new Schedule($schedule['Client_idClient'],
                                        $schedule['Company_idCompany'],
                                        $schedule['paidOut'],
                                        $schedule['totalPaid'],
                                        $schedule['voucherService'],
                                        $schedule['cancellationReason'],
                                        $schedule['observation'],
                                        $schedule['status'],
                                        new \DateTime($schedule['startTime']),
                                        new \DateTime($schedule['endTime']),
                                        new \DateTime($schedule['dateSchedule']),
                                        new \DateTime($schedule['created_at']),
                                        $schedule['cancellationDescripton'] == null ? '' : $schedule['cancellationDescripton']);

            $scheduleObj->setId($schedule['idSchedule']);
            $client = new Client(); 
            $client = $client->getById($db,$schedule['Client_idClient']);
            $scheduleObj->setClient($client);
            array_push($arrayObjectsSchedule,$scheduleObj);
        }
        return $arrayObjectsSchedule;
    }

    public function getByCompanyByStatus(Db $db,$idCompany,$status){
        $db->setTable($this->table);
        $schedules = $db->query("*","Company_idCompany={$idCompany} AND status='{$status}'");
        $arrayObjectsSchedule =[];
        foreach ($schedules as $schedule){
            $scheduleObj = new Schedule($schedule['Client_idClient'],$schedule['Company_idCompany'],$schedule['paidOut'],$schedule['totalPaid'],$schedule['voucherService'],$schedule['cancellationReason'],$schedule['observation'],$schedule['status'],new \DateTime($schedule['startTime']),new \DateTime($schedule['endTime']),new \DateTime($schedule['dateSchedule']),new \DateTime($schedule['created_at']));
            $scheduleObj->setId($schedule['idSchedule']);
            $client = new Client(); 
            $client = $client->getById($db,$schedule['Client_idClient']);
            $scheduleObj->setClient($client);
            array_push($arrayObjectsSchedule,$scheduleObj);
        }
        return $arrayObjectsSchedule;
    }

    public function getByClient(Db $db,$idClient){
        $db->setTable($this->table);
        $schedules = $db->query("*","Client_idClient={$idClient}");
        $arrayObjectsSchedule =[];
        foreach ($schedules as $schedule){
            $scheduleObj = new Schedule($schedule['Client_idClient'],
                                        $schedule['Company_idCompany'],
                                        $schedule['paidOut'],
                                        $schedule['totalPaid'],
                                        $schedule['voucherService'],
                                        $schedule['cancellationReason'],
                                        $schedule['observation'],
                                        $schedule['status'],
                                        new \DateTime($schedule['startTime']),
                                        new \DateTime($schedule['endTime']),
                                        new \DateTime($schedule['dateSchedule']),
                                        new \DateTime($schedule['created_at']),
                                        $schedule['cancellationDescripton'] == null ? '' : $schedule['cancellationDescripton']);

            $scheduleObj->setId($schedule['idSchedule']);
            array_push($arrayObjectsSchedule,$scheduleObj);
        }
        return $arrayObjectsSchedule;
    }
    
    public function getByService(Db $db,$idService,$idCompany){
        $db->setTable($this->tableServices);
        $idsSchedules = $db->query("Schedules_idSchedule","Services_idService={$idService} AND Services_Company_idCompany={$idCompany}");
        $arrayObjectsSchedule =[];
        $db->setTable($this->table);
        $scheduleObj = new Schedule();
        foreach ($idsSchedules as $id) {
            $scheduleObj = $scheduleObj->getById($db,$id['Schedules_idSchedule']);
          
            array_push($arrayObjectsSchedule,$scheduleObj);
        }
        return $arrayObjectsSchedule;
    }

    public function getByCollaborator(Db $db, int $idCompany, int $idCollaborator) {
        $db->setTable($this->tableOrders); 
        $tasks = $db->query("schedules_idSchedule", "collaborator_idCollaborator={$idCollaborator} ");
    
        $schedules = [];
        if (count($tasks) > 0) {
            foreach ($tasks as $task) {
                $scheduleObj = new Schedule();
                $scheduleObj = $scheduleObj->getById($task['schedules_idSchedule']);
                array_push($schedules, $scheduleObj);
            }
        }
        return $schedules;
    }
    

    public function getScheduledTimes($db,$date,$idCompany){
        $db->setTable($this->table);
        $timesScheduled = [];
        $times = $db->query("startTime,endTime"," dateSchedule={$date} AND Company_idCompany={$idCompany}");

        foreach ($times as $time) {
            array_push($timesScheduled,new \DateTime($time['startTime']));
            array_push($timesScheduled,new \DateTime($time['endTime']));
        }
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
                $scheduleObj = new Schedule();
                $scheduleObj = $scheduleObj->getById($db,$schedule['idSchedule']);
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
                $scheduleObj = new Schedule($schedule['Client_idClient'],$schedule['Company_idCompany'],$schedule['paidOut'],$schedule['totalPaid'],$schedule['voucherService'],$schedule['cancellationReason'],$schedule['observation'],$schedule['status'],new \DateTime($schedule['startTime']),new \DateTime($schedule['endTime']),new \DateTime($schedule['dateSchedule']),new \DateTime($schedule['created_at']),$schedule['cancellationDescripton'] == null ? '' : $schedule['cancellationDescripton']);
                $scheduleObj->setId($schedule['idSchedule']);
                array_push($arrayObjectsSchedule,$scheduleObj);
            }
        }
        return $arrayObjectsSchedule;
    }
    
    public function getSchedulesByService(Db $db,int $idCompany,int $idService){
        $scheduleOrders = new ScheduleOrder();
        return count($scheduleOrders->getSchedulesByService($db,$idService));
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
        $scheduleOrders = new ScheduleOrder();
        return count($scheduleOrders->getSchedulesByCollaborator($db,$idCollaborator));
    }

 

    public function insert(Db $db){
        $db->setTable($this->table);
        $data = [
            'paidOut' => $this->getPaidOut(),
            'totalPaid' => $this->getTotalPaid(),
            'Client_idClient' => $this->getIdClient(),
            'voucherService' => $this->getIdVoucherService(),
            'cancellationReason' => $this->getCancellationReason(),
            'cancellationDescripton' => $this->getCancellationDescription(),
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
        
        if ($this->getPaidOut() !== 0) {
            $data['paidOut'] = $this->getPaidOut();
        }
        if ($this->getIdVoucherService() !== 0) {
            $data['voucherService'] = $this->getIdVoucherService();
        }
        if ($this->getCancellationReason() !== '') {
            $data['cancellationReason'] = $this->getCancellationReason();
        }
        if ($this->getObservation() !== '') {
            $data['observation'] = $this->getObservation();
        }
        if ($this->getStatus() !== '') {
            $data['status'] = $this->getStatus();
        }
        if ($this->getStartTime() != '') {
            $data['startTime'] = $this->getStartTime();
        }
        if ($this->getEndTime() != '') {
            $data['endTime'] = $this->getEndTime();
        }
        if ($this->getIdCompany() !== 0) {
            $data['Company_idCompany'] = $this->getIdCompany();
        }
        if ($this->getIdClient() !== 0) {
            $data['Client_idClient'] = $this->getIdClient();
        }
        if ($this->getDateSchedule() !== '') {
            $data['dateSchedule'] = $this->getDateSchedule();
        }
        if ($this->getTotalPaid() !== 0) {
            $data['totalPaid'] = $this->getTotalPaid();
        }
        // if ($this->getPaymentMethod() !== '') {
        //     $data['paymentMethod'] = $this->getPaymentMethod();
        // }

        if ($this->getCancellationDescription() !== '') {
            $data['cancellationDescripton'] = $this->getCancellationDescription();
        }
       
        $data = array_map(function($value) {
            return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
        }, $data);

        if(!empty($data)){
            if($db->update("idSchedule={$id}",$data)){
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

    public function getCancellationDescription(): string {
        return $this->cancellationDescription;
    }

    public function setCancellationDescription(string $cancellationDescription): void {
        $this->cancellationDescription = $cancellationDescription;
    }

    public function getPaymentMethod(): string {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): void {
        $this->paymentMethod = $paymentMethod;
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

    public function setClient(Client $client): void {
        $this->client = $client;
    }
    public function getClient(): Client {
        return $this->client;
    }

    public function getRegistrationDate(): \DateTime {
        return $this->registrationDate;
    }
}

?>