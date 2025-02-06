<?php

namespace App\Models;

use App\Models\CRUD;

class Stamp_state extends CRUD
{
    protected $table = "Stamp_state";
    protected $primaryKey = "id";
    protected $fillable = ['state'];

    public function getStampStates()
    {
        $sql = "SELECT * FROM Stamp_state ORDER BY id ASC";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
