<?php

namespace App\Models;
use App\Models\CRUD;

class Image extends CRUD{
    protected $table = "image";
    protected $primaryKey = "id";
    protected $fillable = ['is_primary', 'name', 'url', 'stamp_id'];

    public function selectImagesByStampId($stampId) {
    $sql = "SELECT *
            FROM image
            WHERE stamp_id = :stamp_id";
    $stmt = $this->prepare($sql);
    $stmt->bindValue(':stamp_id', $stampId, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
}