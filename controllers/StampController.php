<?php

namespace App\Controllers;

use App\Models\Privilege;
use App\Providers\View;
use App\Providers\Auth;

class StampController {
    
    public $user;
    public $validator;
    public $view;

    public function __construct($view = null) {
        $this->view = $view ?: new View();
    }
    public function create() {
        if(!Auth::session()){
            return $this->view->redirect('login');
        }
        return $this->view->render('stamp/create');
    }
}