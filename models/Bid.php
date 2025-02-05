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

    public function selectBidByAuction_id($auction_id)
    {
        $sql = "SELECT * FROM  bid  WHERE auction_id = :auction_id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':auction_id', $auction_id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
