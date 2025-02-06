<?php

namespace App\Models;

use App\models\CRUD;

class Status extends CRUD
{
    protected $table = "Status";
    protected $primaryKey = "id";
    protected $fillable = [
        'state',
    ];
}
