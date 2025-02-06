<?php

namespace App\Controllers;

use App\Models\Auction;
use App\Models\Stamp_state;
use App\Models\Status;
use App\Models\Stamp;
use App\Models\Image;
use App\Models\User;
use App\Models\Bid;
use App\Models\Origin;
/* provider */
use App\Providers\View;

class HomeController
{
    public function index()
    {
        $auctionModel = new Auction();
        $auctions = $auctionModel->select('end_date');

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

        return View::render('home', [
            'auctions'     => $auctionData,
            'origins'      => $origins,
            'stamp_states' => $stamp_states,
            'message' => $message,
        ]);
    }
    // return View::render('home', ['title' => 'Index']);
}
