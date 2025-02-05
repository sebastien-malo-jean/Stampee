<?php

namespace App\Controllers;

/* Models */

use App\Models\Auction;
use App\Models\Status;
use App\Models\Stamp;
use App\Models\Image;
use App\Models\User;
use App\Models\Bid;
/* provider */
use App\Providers\View;

class AuctionController
{
    public $view;

    public function show($data = [])
    {
        if (isset($data['id']) && $data['id'] != null) {
            $auctionModel = new Auction();
            $auction = $auctionModel->selectAllFromTableById('Auction', $data['id']);

            if ($auction) {
                if (!isset($auction['end_date']) || empty($auction['end_date'])) {
                    die("Erreur : end_date est invalide !");
                }

                $auctionDate = new Auction();
                $auctionDate->end_date = $auction['end_date'];
                $auction['timer'] = $auctionDate->getTimer();

                // var_dump($auction['timer']);
                // die();

                $stampModel = new Stamp();
                $stamp = $stampModel->selectAllFromTableById('Stamp', $auction['stamp_id']);

                $statusModel = new Status();
                $status = $statusModel->selectAllFromTableById('Status', $auction['status_id']);

                $userModel = new User();
                $user = $userModel->selectAllFromTableById('User', $stamp['user_id']);

                $imagesModel = new Image();
                $images = $imagesModel->selectImagesByStampId($stamp['id']);
                // var_dump($auction);
                // die();
                return View::render('auction/show', [
                    'auction' => $auction,
                    'stamp' => $stamp,
                    'status' => $status,
                    'user' => $user,
                    'images' => $images
                ]);
            } else {
                return View::render('error', ['message' => 'Enchère introuvable']);
            }
        } else {
            return View::render('error', ['message' => 'ID invalide']);
        }
    }

    public function placeBid($data = [])
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si l'utilisateur est connecté via ses informations existantes
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            return View::render('error', ['message' => 'Vous devez être connecté pour enchérir.']);
        }


        $id = null;

        // Vérifier si l'ID est dans $data
        if (isset($data['id']) && !empty($data['id'])) {
            $id = $data['id'];
        }
        // Vérifier si l'ID est dans $_POST
        elseif (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
        }

        if (!$id) {
            return View::render('error', ['message' => 'ID de l\'enchère invalide']);
        }

        $auctionModel = new Auction();
        $auction = $auctionModel->selectAllFromTableById('Auction', $id);
        $stampModel = new Stamp();
        $stamp = $stampModel->selectAllFromTableById('Stamp', $auction['stamp_id']);
        $imagesModel = new Image();
        $images = $imagesModel->selectImagesByStampId($stamp['id']);
        if (!$auction) {
            return View::render('error', ['message' => 'Enchère introuvable']);
        }

        // Créer un objet utilisateur à partir des données de session
        $user = [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'privilege' => $_SESSION['privilege_id']
        ];

        $bidModel = new Bid();
        $bid = $bidModel->selectBidByAuction_id($auction['id']);
        if (!$bid) {
            $bid = [];
        }


        return View::render("auction/show", [
            'auction' => $auction,
            'bid' => $bid,
            'user' => $user,
            'stamp' => $stamp,
            'images' => $images,
        ]);
    }
}
