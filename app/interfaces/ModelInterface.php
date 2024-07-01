<?php

namespace app\interfaces;
use app\models\database\Db;


interface ModelInterface
{
    public function getAll(Db $db);
    public function getById(Db $db,int $id);
    public function insert(Db $db);
    public function update(Db $db,int $id);
    public function delete(Db $db,int $id);
}

?>