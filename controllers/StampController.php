<?php

namespace App\Controllers;

use App\Models\Stamp;
use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

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

    public function store($data = []) {
        $validator = new Validator;
        $validator->field('name', $data['name'])->min(2)->max(50);
        $validator->field('date', $data['date'])->required();
        $validator->field('print_run', $data['print_run'])->required()->int();
        $validator->field('dimensions', $data['dimensions'])->required();
        $validator->field('certified', $data['certified'])->required();
        $validator->field('description', $data['description'])->required();
        $validator->field('condition_id', $data['condition_id'])->required()->int();
        $validator->field('origin_id', $data['origin_id'])->required()->int();
        $validator->field('color_id', $data['color_id'])->required()->int();
        $validator->field('user_id', $data['user_id'])->required()->int();

        if ($validator->isSuccess()) {
            $stamp = new Stamp;
            $insert = $stamp->insert($data);
            if ($insert) {
                return $this->view->redirect('stamp/show?id='.$insert);
            } else {
                return $this->view->render('error');
            }
        } else {
            $errors = $validator->getErrors();
            $inputs = $_POST;
            return $this->view->render('stamp/create', ['errors'=>$errors, 'inputs'=>$inputs]);
        }
    }
}