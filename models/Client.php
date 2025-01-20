<?php
namespace App\Models;
use App\Models\CRUD;

class Client extends CRUD{
      protected $table = "user";
      protected $primaryKey = "id";
      protected $fillable = ['name', 'username', 'email', 'privilege_id'];

public function selectWithPrivilege() {
    $sql = "SELECT c.*, p.privilege AS privilege_name 
            FROM user c
            LEFT JOIN privilege p ON c.privilege_id = p.id";
    $stmt = $this->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
}