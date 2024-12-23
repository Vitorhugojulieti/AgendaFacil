<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;
use app\models\Collaborator;
use app\models\Service;


class ScheduleOrder implements ModelInterface{
    private int $id;
    private \DateTime $startTime;
    private \DateTime $endTime;
    private int $idSchedule;
    private int $idCollaborator;
    private int $idService;
    private string $table = "schedule_orders";

    public function __construct($idSchedule = 0,
                            $idCollaborator = 0,
                            $idService = 0,
                            $startTime = new \DateTime(),
                            $endTime = new \DateTime()){

        $this->idSchedule = $idSchedule;
        $this->idService = $idService;
        $this->idCollaborator = $idCollaborator;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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
                                                new \DateTime($scheduleFound[0]['created_at']));

        $scheduleObj->setId($scheduleFound[0]['idSchedule']);
        $scheduleObj->setCollaborators(Schedule::getCollaboratorsDb($db,$scheduleFound[0]['idSchedule']));
        $scheduleObj->setServices(Schedule::getServicesDb($db,$scheduleFound[0]['idSchedule']));
        return $scheduleObj;
    }

    public function getBySchedule(Db $db,$idSchedule){
        $db->setTable($this->table);
        $collaboratorManager = new Collaborator();
        $serviceManager = new Service();
        $orders = $db->query("*","schedules_idSchedule={$idSchedule}");
        $arrayObjectsOrders =[];
        foreach ($orders as $order){
            $scheduleObj = new ScheduleOrder($order['schedules_idSchedule'],
                                                $order['collaborator_idCollaborator'],
                                                $order['services_idService'],
                                                new \DateTime($order['startTime']),
                                                new \DateTime($order['endTime']));
            $scheduleObj->setId($order['idschedule_order']);
            array_push($arrayObjectsOrders,$scheduleObj);
        }
        return $arrayObjectsOrders;
    }

    public function getSchedulesByCollaborator(
        Db $db,
        int $idCollaborator,
        int $currentPage = 1,
        int $recordsPerPage = 10
    ) {
        $db->setTable($this->table);
    
        // Consulta para obter os IDs de agendamentos relacionados ao colaborador
        $where = "collaborator_idCollaborator = {$idCollaborator}";
        $paginationResult = $db->paginate($currentPage, $recordsPerPage, "schedules_idSchedule", $where);
        $orders = $paginationResult['data']; // Resultados paginados
    
        $arrayObjectsSchedules = [];
    
        // Criando objetos de agendamento para cada ID retornado
        foreach ($orders as $order) {
            $scheduleObj = new Schedule();
            $scheduleObj = $scheduleObj->getById($db, $order['schedules_idSchedule']);
            array_push($arrayObjectsSchedules, $scheduleObj);
        }
    
        // Retornando os resultados com os dados de paginação
        return [
            'schedules' => $arrayObjectsSchedules,
            'pagination' => [
                'currentPage' => $paginationResult['currentPage'],
                'recordsPerPage' => $paginationResult['recordsPerPage'],
                'totalRecords' => $paginationResult['totalRecords'],
                'totalPages' => $paginationResult['totalPages']
            ]
        ];
    }
    

    public function getSchedulesByService(Db $db,$idService){
        $db->setTable($this->table);
        $collaboratorManager = new Collaborator();
        $serviceManager = new Service();
        $orders = $db->query("schedules_idSchedule","services_idService={$idService}");
        $arrayObjectsSchedules =[];
        foreach ($orders as $order){
            $scheduleObj = new Schedule();
            $scheduleObj= $scheduleObj->getById($db,$order['schedules_idSchedule']);
            array_push($arrayObjectsSchedules,$scheduleObj);
        }
        return $arrayObjectsSchedules;
    }

    public function insert(Db $db){
        $db->setTable($this->table);
        $data = [
            'Schedules_idSchedule' => $this->getIdSchedule(),
            'Collaborator_idCollaborator' => $this->getIdCollaborator(),
            'Services_idService'=>$this->getIdService(),
            'startTime'=>$this->getStartTime(),
            'endTime'=>$this->getEndTime(),
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

    //setters and getters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
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

    public function getIdSchedule(): int {
        return $this->idSchedule;
    }

    public function setIdSchedule(int $idSchedule): void {
        $this->idSchedule = $idSchedule;
    }

    public function getIdCollaborator(): int {
        return $this->idCollaborator;
    }

    public function setIdCollaborator(int $idCollaborator): void {
        $this->idCollaborator = $idCollaborator;
    }

    public function getIdService(): int {
        return $this->idService;
    }

    public function setIdService(int $idService): void {
        $this->idService = $idService;
    }

    public function getService(): Service {
        $db = new Db();
        $db->connect();
        $service = new Service();
        $service = $service->getById($db,$this->getIdService());
        return $service;
    }

    public function getCollaborator(): Collaborator {
        $db = new Db();
        $db->connect();
        $collaborator = new Collaborator();
        $collaborator = $collaborator->getById($db,$this->getIdCollaborator());
        return $collaborator;
    }

}


?>