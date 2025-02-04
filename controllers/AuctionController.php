<?php

namespace App\Controllers;

/* Models */

use App\Models\auction;
use App\Models\Status;
/* provider */

use App\Providers\View;


class AuctionController
{
    public $view;

    public function show($data = [])
    {
        if (isset($data['id']) && $data['id'] != null) {
            $auctions = new auction();
            $auction = $auctions->selectAllFromTableById('auction', $data['id']);

            // Vérifie si l'enchère existe
            if ($auction) {
                return View::render('auction/show', ['auction' => $auction]);
            } else {
                // L'enchère n'existe pas, renvoie une page d'erreur ou une vue spécifique
                return View::render('error', ['message' => 'Enchère introuvable']);
            }
        } else {
            return View::render('error');
        }
    }
}