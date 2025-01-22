<?php
namespace App\Models;
use App\Models\CRUD;

class Privilege extends CRUD implements PrivilegeInterface{
    protected $table = "privilege";
    protected $primaryKey = "id";

}