<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Privilege;
use App\Providers\View;
use App\Providers\Validator;

class UserController {
    public $user;
    public $validator;
    public $privilege;
    public $view;

    public function __construct($view = null) {
        $this->view = $view ?: new View();
    }

    public function create() {
        $privilege = new Privilege;
        $privileges = $privilege->select('privilege');
        return $this->view->render('user/create', ['privileges'=>$privileges]);
    }

    public function store($data = []) {
        $validator = new Validator;
        $validator->field('name', $data['name'])->min(2)->max(50);
        $validator->field('username', $data['username'])->unique('User')->email()->min(2)->max(50);
        $validator->field('password', $data['password'])->min(6)->max(20);
        $validator->field('email', $data['email'])->required()->email()->max(100)->matches($data['username'], $data['username']);
        $validator->field('privile_id', $data['privilege_id'])->required()->int();

        if($validator->isSuccess()){

            $user = new User;
            $data['password'] = $user->hashPassword($data['password']);
            $insert = $user->insert($data);
            if($insert){
                echo "Redirecting to login...";
                $this->view->redirect('login');
                exit();
            }else{
                return $this->view->render('error');
            }
        }else{
            $errors = $validator->getErrors();
            $privilege = new Privilege;
            $privileges = $privilege->select('privilege');
            return $this->view->render('user/create', ['errors'=>$errors, 'user'=>$data, 'privileges'=>$privileges]);
        }
    }
}