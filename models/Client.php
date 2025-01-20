<?php
namespace App\Models;
use App\Models\CRUD;

class Client extends CRUD{
      protected $table = "user";
      protected $primaryKey = "id";
      protected $fillable = ['name', 'username', 'email', 'privilege',];
}