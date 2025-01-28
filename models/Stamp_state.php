<?php
namespace App\Models;
use App\Models\CRUD;

class Stamp_state extends CRUD{
    protected $table = "stamp_state";
    protected $primaryKey = "id";
    protected $fillable = ['state'];
}