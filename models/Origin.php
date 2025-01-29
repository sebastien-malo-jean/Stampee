<?php
namespace App\Models;
use App\Models\CRUD;

class Origin extends CRUD{
    protected $table = "origin";
    protected $primaryKey = "id";
    protected $fillable = ['country'];

    public function getOrigins() {
        $sql = "SELECT * FROM origin ORDER BY id ASC";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}