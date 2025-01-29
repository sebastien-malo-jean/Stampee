<?php

namespace App\Models;

use App\Models\CRUD;

class Stamp extends CRUD
{
    protected $table = "stamp";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'date',
        'print_run',
        'dimensions',
        'certified',
        'description',
        'stamp_state_id',
        'origin_id',
        'color_id',
        'user_id'
    ];
}
