<?php

namespace App\Models;

use App\models\CRUD;

class Bid extends CRUD
{
    protected $table = "bid";
    protected $primaryKey = "id";
    protected $fillable = [
        'value',
        'date',
        'auction_id',
        'user_id',
    ];
}
