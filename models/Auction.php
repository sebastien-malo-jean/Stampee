<?php

namespace App\Models;

use App\Models\CRUD;
use DateTime;

class Auction extends CRUD

{
    public $start_date;
    public $end_date;

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

    public function getTimer()
    {
        $now = new DateTime();
        $end = new DateTime($this->end_date);
        $diff = $now->diff($end);

        if ($now >= $end) {
            return "Terminé";
        }

        return $diff->format('%d jours %h heures %i minutes');
    }
}
