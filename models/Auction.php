<?php

namespace App\Models;

use App\Models\CRUD;
use DateTime;

class Auction extends CRUD

{
    public $start_date;
    public $end_date;

    protected $table = "Auction";
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

    public function getFilteredAuctions(array $filters)
    {
        $sql = "SELECT Auction.* 
            FROM Auction 
            JOIN Stamp ON Auction.stamp_id = Stamp.id
            JOIN Origin ON Stamp.origin_id = Origin.id
            WHERE 1=1";
        $params = [];

        // Filtre sur le nom (du timbre) : la colonne 'name' se trouve dans la table Stamp
        if (!empty($filters['search'])) {
            $sql .= " AND Stamp.name LIKE :search";
            $params[':search'] = "%" . $filters['search'] . "%";
        }

        // Filtre sur le prix plancher (Auction.floor_price)
        if (!empty($filters['price'])) {
            $sql .= " AND Auction.floor_price <= :price";
            $params[':price'] = $filters['price'];
        }

        // Filtre sur le pays d'origine : on utilise l'identifiant de l'origine
        if (!empty($filters['pays'])) {
            $sql .= " AND Origin.id = :pays";
            $params[':pays'] = $filters['pays'];
        }

        // Filtre sur l'année de publication : supposons que Stamp.date contient l'année
        if (!empty($filters['year'])) {
            $sql .= " AND Stamp.date = :year";
            $params[':year'] = $filters['year'];
        }

        // Filtre sur la condition du timbre : en supposant que Stamp.stamp_state_id représente la condition
        if (!empty($filters['condition'])) {
            $sql .= " AND Stamp.stamp_state_id = :condition";
            $params[':condition'] = $filters['condition'];
        }

        // Filtre sur la date de début (de l'enchère)
        if (!empty($filters['start_date'])) {
            $sql .= " AND Auction.start_date >= :start_date";
            $params[':start_date'] = $filters['start_date'];
        }

        // Filtre sur la date de fin (de l'enchère)
        if (!empty($filters['end_date'])) {
            $sql .= " AND Auction.end_date <= :end_date";
            $params[':end_date'] = $filters['end_date'];
        }


        // Préparation et exécution de la requête avec PDO
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
