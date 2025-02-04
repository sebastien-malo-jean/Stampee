<?php

namespace App\Models;

use App\models\CRUD;

class Status extends CRUD
{
    protected $table = "status";
    protected $primaryKey = "id";
    protected $fillable = [
        'state',
    ];
}
