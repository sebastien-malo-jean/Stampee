<?php

namespace App\Controllers;

use App\Models\Stamp;
use App\Models\Image;
use App\Models\Origin;
use App\Models\Stamp_state;
use App\Models\Color;
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
        
        $user = Auth::user();

        $origin = new Origin();
        $origins = $origin->select('country');
        $stamp_state = new Stamp_state();
        $stamp_states = $stamp_state->select('state');
        $color = new Color();
        $colors = $color->select('name');
        return $this->view->render('stamp/create',['origins'=>$origins, 'stamp_states'=>$stamp_states, 'colors'=>$colors, 'user'=>$user]);
    }

    public function store($data = []) {
        $validator = new Validator;
        $validator->field('name', $data['name'])->min(2)->max(50);
        $validator->field('date', $data['date'])->required();
        $validator->field('print_run', $data['print_run'])->required()->int();
        $validator->field('dimensions', $data['dimensions'])->required();
        $validator->field('certified', $data['certified'])->required();
        $validator->field('description', $data['description'])->required();
        $validator->field('stamp_state_id', $data['stamp_state_id'])->required()->int();
        $validator->field('origin_id', $data['origin_id'])->required()->int();
        $validator->field('color_id', $data['color_id'])->required()->int();
        $validator->field('user_id', $data['user_id'])->required()->int();

        if ($validator->isSuccess()) {
            $stamp = new Stamp;
            $stampId = $stamp->insert($data);

            if ($stampId) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . ASSET .'img/uploads/';
                if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
             $imageModel = new Image();

             if (!empty($_FILES['image_principale']['name'])) {
                $tmpName = $_FILES['image_principale']['tmp_name'];
                $originalName = $_FILES['image_principale']['name'];
                $userId = $data['user_id'];
                $uploadOk = 1;
                $fileName = $userId . '_' . $originalName;
                
                $destination = $uploadDir . $fileName;
                
                $check = getimagesize($tmpName);
                if($check !== false) {
                  echo "File is an image - " . $check["mime"] . ".";
                  $uploadOk = 1;
                } else {
                  echo "File is not an image.";
                  $uploadOk = 0;
                }
                if (move_uploaded_file($tmpName, $destination)) {
                    $imageModel->insert([
                        'stamp_id'   => $stampId,
                        'name'=> $originalName,
                        'url'        => ASSET .'img/uploads/' . $fileName,
                        'is_primary' => 1,
                    ]);
                }
            }

            if (!empty($_FILES['images_supplementaires']['name'][0])) {
                foreach ($_FILES['images_supplementaires']['name'] as $index => $name) {
                    if (!empty($name)) {
                        $tmpName    = $_FILES['images_supplementaires']['tmp_name'][$index];
                        $originalName   = basename($name);
                        $userId     = $data['user_id'];
                        $fileName   = $userId . '_' . $originalName;
                        $destination = $uploadDir . '/' . $fileName;

                        if (move_uploaded_file($tmpName, $destination)) {
                            $imageModel->insert([
                                'stamp_id'   => $stampId,
                                'name'       => $originalName,
                                'url'        => ASSET .'img/uploads/' . $fileName,
                                'is_primary' => 0,
                            ]);
                        }
                    }
                }
            }
            return $this->view->redirect('stamp/show?id=' . $stampId);

        } else {
            return $this->view->render('error');
        }
    } else {
        $errors = $validator->getErrors();
        $inputs = $_POST;
        return $this->view->render('stamp/create', ['errors' => $errors, 'inputs' => $inputs]);
    }

    }

    public function show($data = []) {
        if (isset($data['id']) && $data['id'] != null) {
            $image = new Image;
            $images = $image->selectImagesByStampId($data['id']);
            $stamp = new Stamp;
            $selectId = $stamp->selectId($data['id']);
            if ($selectId) {
                return $this->view->render('stamp/show', ['stamp' => $selectId, 'images' => $images]);
            } else {
                return $this->view->render('error');
            }
        }
        return $this->view->render('error');
    }

    public function edit($data = []) {
        if (isset($data['id']) && $data['id'] != null) {
            $stamp = new Stamp;
            $selectId = $stamp->selectId($data['id']);
            if ($selectId) {
                $origin = new Origin();
                $origins = $origin->select('country');
                $stamp_state = new Stamp_state();
                $stamp_states = $stamp_state->select('state');
                $color = new Color();
                $colors = $color->select('name');
                return $this->view->render('stamp/edit', ['stamp' => $selectId, 'origins' => $origins, 'stamp_states' => $stamp_states, 'colors' => $colors]);
            } else {
                return $this->view->render('error');
            }
        }
        return $this->view->render('error');
    }
}