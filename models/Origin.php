<?php
namespace App\Models;
use App\Models\CRUD;

class Origin extends CRUD{
    protected $table = "origin";
    protected $primaryKey = "id";
    protected $fillable = ['country'];
}