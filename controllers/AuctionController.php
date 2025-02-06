<?php

namespace App\Controllers;

/* Models */

use App\Models\Auction;
use App\Models\Stamp_state;
use App\Models\Status;
use App\Models\Stamp;
use App\Models\Image;
use App\Models\User;
use App\Models\Bid;
use App\Models\Color;
use App\Models\Origin;
/* provider */
use App\Providers\View;
use App\Providers\Validator;

class AuctionController
{
    public $view;

    public function show($data = [])
    {
        if (isset($data['id']) && $data['id'] != null) {
            $auctionModel = new Auction();
            $auction = $auctionModel->selectAllFromTableById('Auction', $data['id']);

            if ($auction) {
                $auctionDate = new Auction();
                $auctionDate->end_date = $auction['end_date'];
                $auction['timer'] = $auctionDate->getTimer();

                $stampModel = new Stamp();
                $stamp = $stampModel->selectAllFromTableById('Stamp', $auction['stamp_id']);

                $colorModel = new Color();
                $colors = $colorModel->getColors();

                $originModel = new Origin();
                $origins = $originModel->getOrigins();

                $stampStateModel = new Stamp_state();
                $stampStates = $stampStateModel->getStampStates();

                $statusModel = new Status();
                $status = $statusModel->selectAllFromTableById('Status', $auction['status_id']);

                $userModel = new User();
                $user = $userModel->selectAllFromTableById('User', $stamp['user_id']);

                $imagesModel = new Image();
                $images = $imagesModel->selectImagesByStampId($stamp['id']);

                $bidModel = new Bid();
                $bids = $bidModel->selectBidByAuction_id($auction['id']);

                foreach ($bids as &$b) {
                    $userBid = new User();
                    $userBidInfo = $userBid->selectAllFromTableById('User', $b['user_id']);
                    $b['user_name'] = $userBidInfo['name']; // Ajouter le nom d'utilisateur

                }
                $biggestBidValueModel = new Bid();
                $biggestBidValue = $biggestBidValueModel->findBiggestValue($auction['id']);

                if ($biggestBidValue) {
                    $userModel = new User();
                    $userBidInfo = $userModel->selectAllFromTableById('User', $biggestBidValue['user_id']);
                    $biggestBidValue['user_name'] = $userBidInfo['name']; // Ajouter le nom d'utilisateur
                }

                return View::render('auction/show', [
                    'auction' => $auction,
                    'stamp' => $stamp,
                    'status' => $status,
                    'user' => $user,
                    'images' => $images,
                    'colors' => $colors,
                    'origins' => $origins,
                    'stamp_states' => $stampStates,
                    'bids' => $bids,
                    'biggestBidValue' => $biggestBidValue,
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
        $validator = new Validator();
        $validator->connected();

        $id = null;
        if (isset($data['id']) && !empty($data['id'])) {
            $id = $data['id'];
        } elseif (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
        }

        if (!$id) {
            return View::render('error', ['message' => "ID de l'enchère invalide"]);
        }

        // Récupérer l'enchère
        $auctionModel = new Auction();
        $auction = $auctionModel->selectAllFromTableById('Auction', $id);

        if (!$auction) {
            return View::render('error', ['message' => 'Enchère introuvable']);
        }

        // Vérifier si une enchère existe déjà pour cet utilisateur
        $bidModel = new Bid();
        $lastBid = $bidModel->findBiggestValue($id);

        if ($lastBid && $lastBid['user_id'] == $_SESSION['user_id']) {
            $validator->field('user_id', $_SESSION['user_id'])->notSameUserAsLastBid($id);
        }

        if (!isset($_POST['value']) || empty($_POST['value'])) {
            $validator->field('value', $_POST['value'])->required();
        }

        $bidValue = (float)$_POST['value'];
        $validator->field('value', $bidValue)->higherBid($auction['id']);

        if (!$validator->isSuccess()) {
            $errors = $validator->getErrors();

            // Récupérer toutes les informations pour l'affichage correct
            return $this->renderAuctionPage($id, $errors);
        }

        // Enregistrer l'enchère
        $success = $bidModel->placeBid($_SESSION['user_id'], $id, $bidValue);

        if (!$success) {
            return View::render('error', ['message' => "Erreur lors de l'enregistrement de l'enchère."]);
        }

        // Rafraîchir les données après l'enchère
        return $this->renderAuctionPage($id);
    }

    public function auctionList()
    {
        // Récupérer les paramètres GET (en vérifiant qu'ils existent)
        $search      = isset($_GET['search']) ? trim($_GET['search']) : null;
        $price       = isset($_GET['price']) ? (float) $_GET['price'] : null;
        $pays        = isset($_GET['pays']) ? $_GET['pays'] : null;
        $year        = isset($_GET['year']) ? $_GET['year'] : null;
        $condition   = isset($_GET['condition']) ? $_GET['condition'] : null;
        $start_date  = isset($_GET['start_date']) ? $_GET['start_date'] : null;
        $end_date    = isset($_GET['end_date']) ? $_GET['end_date'] : null;

        $auctionModel = new Auction();
        $auctions = $auctionModel->getFilteredAuctions([
            'search'     => $search,
            'price'      => $price,
            'pays'       => $pays,
            'year'       => $year,
            'condition'  => $condition,
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);

        // Récupérer les données supplémentaires pour les filtres (origines, conditions, etc.)
        $originModel = new Origin();
        $origins = $originModel->getOrigins();

        $stampStateModel = new Stamp_state();
        $stamp_states = $stampStateModel->getStampStates();

        $auctionData = [];
        if ($auctions) {
            foreach ($auctions as $auction) {
                // Calcul du timer, récupération du stamp, statut, images, bids, etc.
                $auctionDate = new Auction();
                $auctionDate->end_date = $auction['end_date'];
                $auction['timer'] = $auctionDate->getTimer();

                $stampModel = new Stamp();
                $stamp = $stampModel->selectAllFromTableById('Stamp', $auction['stamp_id']);

                $statusModel = new Status();
                $status = $statusModel->selectAllFromTableById('Status', $auction['status_id']);

                $userModel = new User();
                $user = $userModel->selectAllFromTableById('User', $stamp['user_id']);

                $imagesModel = new Image();
                $images = $imagesModel->selectImagesByStampId($stamp['id']);

                $bidModel = new Bid();
                $bids = $bidModel->selectBidByAuction_id($auction['id']);

                foreach ($bids as &$b) {
                    $userBid = new User();
                    $userBidInfo = $userBid->selectAllFromTableById('User', $b['user_id']);
                    $b['user_name'] = $userBidInfo['name'];
                }

                $biggestBidValue = $bidModel->findBiggestValue($auction['id']);
                if ($biggestBidValue) {
                    $userBidInfo = $userModel->selectAllFromTableById('User', $biggestBidValue['user_id']);
                    $biggestBidValue['user_name'] = $userBidInfo['name'];
                }

                $auctionData[] = [
                    'auction'         => $auction,
                    'stamp'           => $stamp,
                    'status'          => $status,
                    'user'            => $user,
                    'images'          => $images,
                    'bids'            => $bids,
                    'biggestBidValue' => $biggestBidValue,
                ];
            }
        }
        if (empty($auctionData)) {
            $message = "Aucune enchère n'a été trouvée.";
        } else {
            $message = "";
        }

        return View::render('auction/showList', [
            'auctions'     => $auctionData,
            'origins'      => $origins,
            'stamp_states' => $stamp_states,
            'message' => $message,
        ]);
    }

    private function renderAuctionPage($id, $errors = [])
    {
        $auctionModel = new Auction();
        $auction = $auctionModel->selectAllFromTableById('Auction', $id);

        $stampModel = new Stamp();
        $stamp = $stampModel->selectAllFromTableById('Stamp', $auction['stamp_id']);

        $colorModel = new Color();
        $colors = $colorModel->getColors();

        $originModel = new Origin();
        $origins = $originModel->getOrigins();

        $stampStateModel = new Stamp_state();
        $stampStates = $stampStateModel->getStampStates();

        $statusModel = new Status();
        $status = $statusModel->selectAllFromTableById('Status', $auction['status_id']);

        $userModel = new User();
        $user = $userModel->selectAllFromTableById('User', $stamp['user_id']);

        $imagesModel = new Image();
        $images = $imagesModel->selectImagesByStampId($stamp['id']);

        $bidModel = new Bid();
        $bids = $bidModel->selectBidByAuction_id($auction['id']);

        // Ajout du nom de l'utilisateur pour la plus haute enchère
        $biggestBidValue = $bidModel->findBiggestValue($auction['id']);
        if ($biggestBidValue) {
            $userBidInfo = $userModel->selectAllFromTableById('User', $biggestBidValue['user_id']);
            $biggestBidValue['user_name'] = $userBidInfo['name'];
        }

        return View::render('auction/show', [
            'auction' => $auction,
            'stamp' => $stamp,
            'status' => $status,
            'user' => $user,
            'images' => $images,
            'colors' => $colors,
            'origins' => $origins,
            'stamp_states' => $stampStates,
            'bids' => $bids,
            'biggestBidValue' => $biggestBidValue,
            'errors' => $errors
        ]);
    }
}
