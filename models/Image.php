<?php

namespace App\Models;

use App\Models\CRUD;

class Image extends CRUD
{
    protected $table = "Image";
    protected $primaryKey = "id";
    protected $fillable = ['is_primary', 'name', 'url', 'stamp_id'];

    public function selectImageById($id)
    {
        $sql = "SELECT * FROM Image WHERE id = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectImagesByStampId($stampId)
    {
        $sql = "SELECT *
            FROM Image
            WHERE stamp_id = :stamp_id
            ORDER BY is_primary DESC";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':stamp_id', $stampId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectPrimaryImageByStampId($stampId)
    {
        $sql = "SELECT *
            FROM Image
            WHERE stamp_id = :stamp_id
            AND is_primary = 1";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':stamp_id', $stampId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectImageByNameAndStampId($name, $stampId)
    {
        $sql = "SELECT * FROM Image WHERE name = :name AND stamp_id = :stamp_id";
        $params = ['name' => $name, 'stamp_id' => $stampId];
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->execute($params);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteByStampId($stampId)
    {
        $sql = "DELETE FROM Image WHERE stamp_id = :stamp_id";
        $params = ['stamp_id' => $stampId];
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':stamp_id', $stampId, \PDO::PARAM_INT);
        $stmt->execute($params);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
