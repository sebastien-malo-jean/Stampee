<?php

namespace App\Controllers;

use App\Models\Client;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

class ClientController
{
    public function index()
    {
        if (Auth::session()) {
            $client = new Client;
            $select = $client->select('name');
            if ($select) {
                return View::render('client/index', ['clients' => $select]);
            }
            return View::render('error');
        }
    }

    public function show($data = [])
    {
        if (isset($data['id']) && $data['id'] != null) {
            $client = new Client;
            $selectId = $client->selectId($data['id']);
            if ($selectId) {
                return View::render('client/show', ['client' => $selectId]);
            } else {
                return View::render('error');
            }
        }
        return View::render('error');
    }

    public function create()
    {
        View::render('client/create');
    }

    public function store($data = [])
    {
        $validator = new Validator;
        $validator->field('name', $data['name'])->min(2)->max(45);
        $validator->field('username', $data['username'])->min(2)->max(45);
        $validator->field('password', $data['password'])->max(20);
        $validator->field('email', $data['email'])->email()->max(50);
        $validator->field('privilege_id', $data['privilege_id'])->int();

        if ($validator->isSuccess()) {
            $client = new Client;
            $insert = $client->insert($data);
            if ($insert) {
                return View::redirect('client/show?id=' . $insert);
            } else {
                return View::render('error');
            }
        } else {
            $errors = $validator->getErrors();
            $inputs = $data;
            return View::render('client/create', ['errors' => $errors, 'inputs' => $inputs]);
        }
    }

    public function edit($get = [])
    {
        if (isset($get['id']) && $get['id'] != null) {
            $client = new Client;
            $selectId = $client->selectId($get['id']);
            if ($selectId) {
                return View::render('client/edit', ['inputs' => $selectId]);
            } else {
                return View::render('error');
            }
        }
        return View::render('error');
    }

    public function update($data = [], $get = [])
    {
        if (isset($get['id']) && $get['id'] != null) {
            $validator = new Validator;
            $validator->field('name', $data['name'])->min(2)->max(45);
            $validator->field('username', $data['username'])->min(2)->max(45);
            $validator->field('password', $data['password'])->max(20);
            $validator->field('email', $data['email'])->email()->max(50);
            $validator->field('privilege_id', $data['privilege_id'])->int();

            if ($validator->isSuccess()) {
                $client = new Client;
                $update = $client->update($data, $get['id']);
                if ($update) {
                    return View::redirect('client/show?id=' . $get['id']);
                } else {
                    return View::render('error');
                }
            } else {
                $errors = $validator->getErrors();
                $inputs = $data;
                return View::render('client/edit', ['errors' => $errors, 'inputs' => $inputs]);
            }
        }
        return View::render('error');
    }

    public function delete($data = [])
    {
        $client = new Client;
        $delete = $client->delete($data['id']);
        if ($delete) {
            return View::redirect('client');
        }
        return View::render('error');
    }
}
