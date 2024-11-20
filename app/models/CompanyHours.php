<?php
namespace app\models;
use app\models\database\Db;


class CompanyHours{
    private int $id;
    private int $idCompany;
    private int $dayOfWeek;         //(0 = domingo, 6 = sabado)
    private \DateTime $openingHoursMorningStart;
    private \DateTime $openingHoursMorningEnd;
    private \DateTime $openingHoursAfternoonStart;
    private \DateTime $openingHoursAfternoonEnd;
    private $table = "company_hours";

    public function __construct(
                        $idCompany = 0,
                        $dayOfWeek = 0,
                        $openingHoursMorningStart =  new \DateTime,
                        $openingHoursMorningEnd = new \DateTime,
                        $openingHoursAfternoonStart = new \DateTime,
                        $openingHoursAfternoonEnd = new \DateTime,
                        ){
        $this->idCompany = $idCompany;
        $this->dayOfWeek = $dayOfWeek;
        $this->openingHoursMorningStart = $openingHoursMorningStart;
        $this->openingHoursMorningEnd = $openingHoursMorningEnd;
        $this->openingHoursAfternoonStart = $openingHoursAfternoonStart;
        $this->openingHoursAfternoonEnd = $openingHoursAfternoonEnd;
    }

    public function getByIdCompany(Db $db, int $idCompany){
        $db->setTable($this->table);
        $hours = $db->query("*","company_id={$idCompany}");
        $arrayHours = []; 

        if(!$hours){
            return [];
        }
        
        foreach ($hours as $hour) {
            $hoursObject = new CompanyHours($hour['company_id'],
                                    $hour['day_of_week'],
                                    new \DateTime($hour['morning_open']),
                                    new \DateTime($hour['morning_close']),
                                    new \DateTime($hour['afternoon_open']),
                                    new \DateTime($hour['afternoon_close']));

            $hoursObject->setId($hour['id']);
            array_push($arrayHours,$hoursObject);
        }
        return $arrayHours;
    }

    public function insert(Db $db){
        $db->setTable($this->table);
        
        $data = [
            'company_id' => $this->getIdCompany(),
            'day_of_week' => $this->getDayOfWeek(),
            'morning_open' => $this->getOpeningHoursMorningStart(),
            'morning_close' => $this->getOpeningHoursMorningEnd(),
            'afternoon_open' => $this->getOpeningHoursAfternoonStart(),
            'afternoon_close' => $this->getOpeningHoursAfternoonEnd(),
        ];
    
        $data = array_map(function($value) {
            return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
        }, $data);
            
        if ($db->insert($data)) {
            return true;
        }

        return false;
    }

    public function update(Db $db){
        $db->setTable($this->table);
        $data = [];
        
        if ($this->getIdCompany() !== '') {
            $data['company_id'] = $this->getIdCompany();
        }
        if ($this->getDayOfWeek() !== '') {
            $data['day_of_week'] = $this->getDayOfWeek();
        }
        if ($this->getOpeningHoursMorningStart() != '') {
            $data['morning_open'] = $this->getOpeningHoursMorningStart();
        }

        if ($this->getOpeningHoursMorningEnd() != '') {
            $data['morning_close'] = $this->getOpeningHoursMorningEnd();
        }

        if ($this->getOpeningHoursAfternoonStart() != '') {
            $data['afternoon_open'] = $this->getOpeningHoursAfternoonStart();
        }

        if ($this->getOpeningHoursAfternoonEnd() != '') {
            $data['afternoon_close'] = $this->getOpeningHoursAfternoonEnd();
        }

        $data = array_map(function($value) {
            return $value instanceof \DateTime ? $value->format('Y-m-d H:i:s') : $value;
        }, $data);

        if(!empty($data)){
            if($db->update("id={$this->getId()} AND company_id={$this->getIdCompany()}",$data)){
                return true;
            }
        }

        return false;
    }

    public function deleteAllCompany(Db $db, int $idCompany){
        $db->setTable($this->table);
        return $db->delete("company_id={$idCompany}");
    }

    public function delete(Db $db, int $id){
        $db->setTable($this->table);
        return $db->delete("id={$id}");
    }


    //getters e setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setDayOfWeek(int $dayOfWeek): void {
        $this->dayOfWeek = $dayOfWeek;
    }

    public function getDayOfWeek(): int {
        return $this->dayOfWeek;
    }
    
    public function setOpeningHoursMorningStart(\DateTime $openingHoursMorningStart): void {
        $this->openingHoursMorningStart = $openingHoursMorningStart;
    }

    public function getOpeningHoursMorningStart(): \DateTime {
        return $this->openingHoursMorningStart;
    }

    public function setOpeningHoursMorningEnd(\DateTime $openingHoursMorningEnd): void {
        $this->openingHoursMorningEnd = $openingHoursMorningEnd;
    }

    public function getOpeningHoursMorningEnd(): \DateTime {
        return $this->openingHoursMorningEnd;
    }
    
    public function getOpeningHoursAfternoonStart(): \DateTime {
        return $this->openingHoursAfternoonStart;
    }

    public function setOpeningHoursAfternoonStart(\DateTime $openingHoursAfternoonStart): void {
        $this->openingHoursAfternoonStart = $openingHoursAfternoonStart;
    }

    public function getOpeningHoursAfternoonEnd(): \DateTime {
        return $this->openingHoursAfternoonEnd;
    }

    public function setOpeningHoursAfternoonEnd(\DateTime $openingHoursAfternoonEnd): void {
        $this->openingHoursAfternoonEnd = $openingHoursAfternoonEnd;
    }

}


?>