<?php
namespace App\Models;
use App\Models\CRUD;

class Condition extends CRUD{
    protected $table = "condition";
    protected $primaryKey = "id";
    protected $fillable = ['state'];
}