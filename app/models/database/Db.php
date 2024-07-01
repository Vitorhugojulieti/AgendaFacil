<?php
namespace app\models\database;

use PDO;

class Db {
    private $host;
    private $port;
    private $user;
    private $dbname;
    private $password;
    private $connection;
    private $table;

    function __construct($host="127.0.0.1",
                         $port="3306",
                         $user="root",
                         $dbname="mvcteste",
                         $password="root") {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
    }

    public function connect() {
        $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname;
        $this->connection = null;
        try {
            $this->connection = new PDO($dsn, $this->user, $this->password);
        } catch(PDOException $e) {
            $message = "DB class connect() = " . $e->getMessage();
            file_put_contents("error.log", $message, FILE_APPEND);
        }
    }

    public function setTable($table = null) {
        $this->table = $table;
    }

    public function query($fields = '*', $where = null, $order = null, $limit = null) {
        $fields = is_null($fields) ? '*' : $fields;
        $where = is_null($where) ? '' : 'WHERE ' . $where;
        $order = is_null($order) ? '' : 'ORDER BY ' . $order;
        $limit = is_null($limit) ? '' : 'LIMIT ' . $limit;
        $query = "SELECT " . $fields . " FROM " . $this->table . " " . $where . " " . $order . " " . $limit;
        return $this->executeSQL($query);
    }

    public function totalRecords() {
        $sql = "SELECT count(*) as total FROM " . $this->table;
        return $this->executeSQL($sql);
    }

    public function executeSQL($query) {
        $data = array();
        $query = trim($query);
        $result = "";
        try {
            $this->connection->beginTransaction();
            $result = $this->connection->query($query);
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            $result = null;
            $message = "DB class executeSQL = " . $e->getMessage();
        }
        if ($result) {
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
        }
        
        if (stripos($query, 'SELECT') === 0) {
            return $data;
        } else {
            return $result !== null; 
        }
    }

    public function insert($data = null) {
        $fields = implode(",", array_keys($data));
        $values = implode("','", array_values($data));
        $query = "INSERT INTO " . $this->table . " (" . $fields . ") VALUES ('" . $values . "')";
        return $this->executeSQL($query);
    }

    public function update($where = null, $data = null) {
        if(!is_null($where)) {
            $values = array();
            foreach($data as $key => $value) {
                $values[] = $key . "='" . $value . "'";
            }
            $values = implode(',', $values);
            $query = "UPDATE " . $this->table . " SET " . $values . " WHERE " . $where;
            return $this->executeSQL($query);
        } else {
            return false;
        }
    }

    public function delete($where = null) {
        if(!is_null($where)) {
            $query = "DELETE FROM " . $this->table . " WHERE " . $where;
            return $this->executeSQL($query);
        } else {
            return false;
        }
    }
}
?>
