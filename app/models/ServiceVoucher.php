<?php
namespace app\models;
use app\models\database\Db;
use app\interfaces\ModelInterface;

class ServiceVoucher implements ModelInterface{
    private int $id;
    private int $idCompany;
    private float $amount;
    private string $dateOfIssue;
    private string $dateExpiration;
    private string $code;
    private string $table = "servicevoucher";

    public function __construct($idCompany = 0, $amount = 0.00, $dateOfIssue = "", $dateExpiration = "", $code = ""){
        $this->idCompany = $idCompany;
        $this->amount = (Float)$amount;
        $this->dateOfIssue = $dateOfIssue;
        $this->dateExpiration = $dateExpiration;
        $this->code = $code;
    }

    public function getAll(Db $db){
        $db->setTable($this->table);
        $vouchers = $db->query("*");
        $arrayObjectsVouchers =[];
        foreach ($vouchers as $voucher){
            $voucherObj = new ServiceVoucher($voucher['amount'],$voucher['dateOfIssue'],$voucher['dateExpiration'],$voucher['code']);
            $voucherObj->setId($voucher['idServiceVoucher']);
            array_push($arrayObjectsVouchers,$voucherObj);
        }
        return $arrayObjectsVouchers;
    }

    public function getById(Db $db, int $id){
        $db->setTable($this->table);
        $voucherFound = $db->query("*","idServiceVoucher={$id}");

        if(!$voucherFound){
            return false;
        }

        $voucherObject = new ServiceVoucher($voucherFound[0]['amount'],$voucherFound[0]['dateOfIssue'],$voucherFound[0]['dateExpiration'],$voucherFound[0]['code']);
        $voucherObject->setId($voucherFound[0]['idServiceVoucher'],);
        return $voucherObject;
    }

    public function insert(Db $db){
        $db->setTable($this->table);
        $data = [
            'amount' => $this->getAmount(),
            'dateOfIssue' => $this->getDateOfIssue(),
            'dateExpiration' => $this->getDateExpiration(),
            'code' => $this->getCode(),
            'Company_idCompany'=>$this->getIdCompany(),
        ];
        if ($db->insert($data)) {
            return true;
        }
        return false;
    }

    public function update(Db $db,int $id){
        $db->setTable($this->table);
        $data = [];
        
        if ($this->getAmount() !== 0.00) {
            $data['amount'] = $this->getAmount();
        }
        if ($this->getDateOfIssue() !== '') {
            $data['dateOfIssue'] = $this->getDateOfIssue();
        }
        if ($this->getDateExpiration() !== '') {
            $data['dateExpiration'] = $this->getDateExpiration();
        }
        if ($this->getIdCompany() !== 0) {
            $data['Company_idCompany'] = $this->getIdCompany();
        }
       
        if(!empty($data)){
            if($db->update("idServiceVoucher={$id}",$data)){
                return true;
            }
        }

        return false;
    }

    public function delete(Db $db,int $id){
        $db->setTable($this->table);
        return $db->delete("idServiceVoucher={$id}");
    }

    //getters and setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getIdCompany(): int {
        return $this->idCompany;
    }

    public function setIdCompany(int $idCompany): void {
        $this->idCompany = $idCompany;
    }

    public function getAmount():float {
        return $this->amount;
    }

    public function setAmount(float $amount) {
        $this->amount = $amount;
    }

    public function getDateOfIssue() {
        return $this->dateOfIssue;
    }

    public function setDateOfIssue(string $dateOfIssue) {
        $this->dateOfIssue = $dateOfIssue;
    }

    public function getDateExpiration() {
        return $this->dateExpiration;
    }

    public function setDateExpiration(string $dateExpiration) {
        $this->dateExpiration = $dateExpiration;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode(string $code) {
        $this->code = $code;
    }
}

?>