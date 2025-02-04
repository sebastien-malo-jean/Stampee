<?php

namespace App\Models;

use App\Models\CRUD;

class Auction extends CRUD
{
    protected $table = "auction";
    protected $primaryKey = "id";
    protected $fillable = [
        'start_date',
        'end_date',
        'floor_price',
        'featured',
        'steamp_id',
        'status_id',
    ];
}