<?php

namespace App\Models;

use App\Models\CRUD;

class Color extends CRUD
{
    protected $table = "Color";
    protected $primaryKey = "id";
    protected $fillable = ['name'];

    public function getColors()
    {
        $sql = "SELECT * FROM Color ORDER BY id ASC";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
