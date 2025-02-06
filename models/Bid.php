<?php

namespace App\Models;

use App\models\CRUD;

class Bid extends CRUD
{
    protected $table = "Bid";
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

    public function placeBid($user_id, $auction_id, $value)
    {
        $sql = "INSERT INTO bid (user_id, auction_id, value, date) VALUES (:user_id, :auction_id, :value, NOW())";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindValue(':auction_id', $auction_id, \PDO::PARAM_INT);
        $stmt->bindValue(':value', $value, \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function findBiggestValue($auction_id)
    {
        $sql = "SELECT * FROM bid WHERE auction_id = :auction_id ORDER BY value DESC LIMIT 1";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':auction_id', $auction_id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
