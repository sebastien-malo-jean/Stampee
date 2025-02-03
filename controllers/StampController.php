<?php

namespace App\Controllers;

use App\Models\Stamp;
use App\Models\Image;
use App\Models\Origin;
use App\Models\Stamp_state;
use App\Models\Color;
use App\Providers\UploadImage;
use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class StampController
{

    public $user;
    public $validator;
    public $view;

    public function __construct($view = null)
    {
        $this->view = $view ?: new View();
    }
    public function create()
    {
        if (!Auth::session()) {
            return $this->view->redirect('login');
        }

        $user = Auth::user();

        $origin = new Origin();
        $origins = $origin->getOrigins();
        $stamp_state = new Stamp_state();
        $stamp_states = $stamp_state->getStampStates();
        $color = new Color();
        $colors = $color->getColors();
        return $this->view->render('stamp/create', ['origins' => $origins, 'stamp_states' => $stamp_states, 'colors' => $colors, 'user' => $user]);
    }

    public function store($data = [])
    {
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
                $imageModel = new Image();

                if (!empty($_FILES['image_principale']['name'])) {
                    // Supprimer l'ancienne image principale avant d'ajouter la nouvelle
                    $existingImage = $imageModel->selectPrimaryImageByStampId($stampId);
                    if ($existingImage) {
                        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . $existingImage['url'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                        $imageModel->delete($existingImage['id']);
                    }
                    $uploadImage = new UploadImage();
                    $uploadImage->uploadImage($_FILES['image_principale'], $stampId, true);
                }

                if (!empty($_FILES['images_supplementaires']['name'][0])) {
                    foreach ($_FILES['images_supplementaires']['name'] as $index => $name) {
                        if (!empty($name)) {
                            $file = [
                                'name' => $name,
                                'tmp_name' => $_FILES['images_supplementaires']['tmp_name'][$index]
                            ];
                            $uploadImage = new UploadImage();

                            $uploadImage->uploadImage($file, $stampId, false);
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

    public function show($data = [])
    {
        if (isset($data['id']) && $data['id'] != null) {
            $user = Auth::user();
            $image = new Image;
            $images = $image->selectImagesByStampId($data['id']);
            $stamp = new Stamp;
            $selectId = $stamp->selectId($data['id']);
            $color = new Color();
            $colors = $color->getColors();
            $origin = new Origin();
            $origins = $origin->getOrigins();
            $stamp_state = new Stamp_state();
            $stamp_states = $stamp_state->getStampStates();
            if ($selectId) {
                return $this->view->render('stamp/show', ['stamp' => $selectId, 'images' => $images, 'user' => $user, 'colors' => $colors, 'origins' => $origins, 'stamp_states' => $stamp_states]);
            } else {
                return $this->view->render('error');
            }
        }
        return $this->view->render('error');
    }

    public function edit($data = [])
    {
        if (isset($data['id']) && $data['id'] != null) {
            $user = Auth::user();
            $stamp = new Stamp;
            $selectId = $stamp->selectId($data['id']);
            if ($selectId) {
                $image = new Image;
                $images = $image->selectImagesByStampId($data['id']);
                $origin = new Origin();
                $origins = $origin->select('country');
                $stamp_state = new Stamp_state();
                $stamp_states = $stamp_state->select('state');
                $color = new Color();
                $colors = $color->select('name');
                return $this->view->render('stamp/edit', ['stamp' => $selectId, 'origins' => $origins, 'stamp_states' => $stamp_states, 'colors' => $colors, 'user' => $user, 'images' => $images]);
            } else {
                return $this->view->render('error');
            }
        }
        return $this->view->render('error');
    }

    public function update($data = [], $get = [])
    {
        if (isset($get['id']) && $get['id'] != null) {
            // Validation des données
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
                $update = $stamp->update($data, $get['id']);

                if ($update) {
                    $imageModel = new Image();
                    $existingImage = $imageModel->selectPrimaryImageByStampId($get['id']);

                    if (!empty($_FILES['image_principale']['name'])) {
                        if ($existingImage) {
                            $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . $existingImage['url'];
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                            $imageModel->delete($existingImage['id']);
                        }
                        $uploadImage = new UploadImage();
                        $uploadImage->uploadImage($_FILES['image_principale'], $get['id'], true);
                    }

                    return $this->view->redirect('stamp/show?id=' . $get['id']);
                } else {
                    return $this->view->render('error');
                }
            } else {
                $errors = $validator->getErrors();
                $inputs = $data;
                return $this->view->render('stamp/edit', ['errors' => $errors, 'inputs' => $inputs]);
            }
        }
        return $this->view->render('error');
    }



    public function delete($data = [])
    {
        if (isset($data['id']) && $data['id'] != null) {
            // Récupérer toutes les images associées au timbre
            $imageModel = new Image();
            $images = $imageModel->selectImagesByStampId($data['id']);

            // Supprimer les fichiers des images
            foreach ($images as $image) {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . $image['url'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Supprimer les images de la base de données
            $imageModel->deleteByStampId($data['id']);

            // Supprimer le timbre
            $stamp = new Stamp;
            $delete = $stamp->delete($data['id']);

            if ($delete) {
                return $this->view->redirect('stamp/create');
            } else {
                return $this->view->render('error');
            }
        }
        return $this->view->render('error');
    }
}