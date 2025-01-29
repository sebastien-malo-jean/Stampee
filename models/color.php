<?php
namespace App\Models;
use App\Models\CRUD;

class Color extends CRUD{
    protected $table = "color";
    protected $primaryKey = "id";
    protected $fillable = ['name'];

public function getColors() {
    $sql = "SELECT * FROM color ORDER BY id ASC";
    $stmt = $this->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


}