<?php
namespace App\Models;
use App\Models\CRUD;

class Stamp extends CRUD{
    protected $table = "stamp";
    protected $primaryKey = "id";
    protected $fillable = ['name', 'date', 'print_run', 'dimension', 'certified', 'description', 'condition_id', 'origin', 'color', 'user_id'];
}