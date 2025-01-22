<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Privilege;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\Mail;
class UserController {
    public $user;
    public $validator;
    public $privilege;
    public $mail;
    // public function __construct()
    // {
    //     Auth::session();
    // }
    public function create() {
        $privilege = new Privilege;
        $privileges = $privilege->select('privilege');
        return View::render('user/create', ['privileges'=>$privileges]);
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
                // Envoyer l'email de validation
                $validationLink = User::generateValidationLink($insert); // $insert contient l'ID de l'utilisateur créé

                $mailer = new PHPMailer(true);
                $mail = new Mail($mailer);
                $subject = "Bienvenue " . $data['name'] . " !";
                $body = "Bonjour " . $data['name'] . ",\n\nCliquez sur le lien suivant pour valider votre email : $validationLink";

                $mail->sendEmail($data['email'], $subject, $body);

                return View::redirect('login');
            }else{
                return View::render('error');
            }
        }else{
            $errors = $validator->getErrors();
            $privilege = new Privilege;
            $privileges = $privilege->select('privilege');
            return View::render('user/create', ['errors'=>$errors, 'user'=>$data, 'privileges'=>$privileges]);
        }
    }
}