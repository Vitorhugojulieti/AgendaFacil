<?php

namespace app\interfaces;
use app\models\database\Db;


interface DatabaseInterface
{
    public function getAll();
    public function getById(int $id);
    public function insert();
    public function update();
    public function delete();
}

?>