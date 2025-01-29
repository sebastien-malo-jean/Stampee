<?php
namespace App\Models;
use App\Models\CRUD;

class Stamp_state extends CRUD{
    protected $table = "stamp_state";
    protected $primaryKey = "id";
    protected $fillable = ['state'];

    public function getStates() {
        $sql = "SELECT * FROM stamp_state ORDER BY id ASC";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}