<?php

namespace App\Controllers;

use App\Models\Stamp;
use App\Models\Image;
use App\Models\Origin;
use App\Models\Stamp_state;
use App\Models\Color;
use App\Models\User;
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
        $origin = new Origin();
        $origins = $origin->select('country');
        $stamp_state = new Stamp_state();
        $stamp_states = $stamp_state->select('state');
        $color = new Color();
        $colors = $color->select('color_name');
        return $this->view->render('stamp/create',['origins'=>$origins, 'stamp_states'=>$stamp_states, 'colors'=>$colors]);
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
                $uploadDir = BASE .'/public/img/uploads/';
                if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
             $imageModel = new Image();

             if (!empty($_FILES['image_principale']['name'])) {
                $tmpName = $_FILES['image_principale']['tmp_name'];
                $filesName = $_FILES['image_principale']['name'];

                $destination = $uploadDir . $filesName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $imageModel->insert([
                        'stamp_id'   => $stampId,
                        'url'        => 'uploads/' . $filesName,
                        'is_primary' => 1,
                    ]);
                }
            }

            if (!empty($_FILES['images_supplementaires']['name'][0])) {
                foreach ($_FILES['images_supplementaires']['name'] as $index => $name) {
                    if (!empty($name)) {
                        $tmpName    = $_FILES['images_supplementaires']['tmp_name'][$index];
                        $fileName   = basename($name);
                        $destination = $uploadDir . '/' . $fileName;

                        if (move_uploaded_file($tmpName, $destination)) {
                            $imageModel->insert([
                                'stamp_id'   => $stampId,
                                'url'        => 'uploads/' . $fileName,
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
}