<?php

namespace App\Controllers;

use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;

class AuthController
{

    public function index()
    {
        return View::render('auth/index');
    }

    public function store($data)
    {
        $validator = new Validator;
        $validator->field('username', $data['username'])->email()->min(2)->max(50);
        $validator->field('password', $data['password'])->min(6)->max(20);
        if ($validator->isSuccess()) {
            $user = new User();
            $checkuser = $user->checkUser($data['username'], $data['password']);
            if ($checkuser) {
                return View::redirect('home');
            } else {
                $errors['message'] = 'Please check your credentials!';
                return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
        }
    }

    public function delete()
    {
        session_destroy();
        return View::redirect('login');
    }

    public function resetPassword()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $message = $_SESSION['message'] ?? null;
        unset($_SESSION['message']);
        return View::render('auth/reset_password', ['message' => $message]);
    }

    public function resetPasswordStore($data)
    {
        $validator = new Validator;
        $validator->field('email', $data['email'])->email();
        if ($validator->isSuccess()) {
            $user = new User();
            $checkuser = $user->checkEmail($data['email']);
            if ($checkuser) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['message'] = 'Un email de réinitialisation a été envoyé.';
                return View::redirect('reset_password');
            } else {
                $errors['message'] = 'Aucun utilisateur trouvé avec cet email.';
                return View::render('auth/reset_password', ['errors' => $errors, 'user' => $data]);
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('auth/reset_password', ['errors' => $errors, 'User' => $data]);
        }
    }
}