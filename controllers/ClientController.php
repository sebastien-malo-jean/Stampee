<?php
namespace App\Controllers;

use App\Models\Client;
use App\Providers\View;

class ClientController {
    public function index() {
        $client = new Client;
        $select = $client->select('name');
        if($select){
            return View::render('client/index', ['clients'=> $select]);
        }
        return View::render('error');
    }
}