<?php

namespace App\Models;

interface PrivilegeInterface
{
    public function select($field = null, $order = 'ASC');
}