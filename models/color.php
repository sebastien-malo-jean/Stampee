<?php
namespace App\Models;
use App\Models\CRUD;

class Color extends CRUD{
    protected $table = "color";
    protected $primaryKey = "id";
    protected $fillable = ['name'];
}