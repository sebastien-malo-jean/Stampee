<?php

namespace App\Providers;

use App\Models\Image;
use App\Providers\Auth;

class UploadImage
{
    function uploadImage($file, $stampId, $isPrimary = false)
    {
        $user = Auth::user();
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . ASSET . '/img/uploads/' . $user . '/' . $stampId . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $tmpName = $file['tmp_name'];
        $originalName = basename($file['name']);
        $fileName = $stampId . '_' . time() . '_' . $originalName;
        $destination = $uploadDir . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));

        if (in_array($imageFileType, $allowedTypes) && move_uploaded_file($tmpName, $destination)) {
            $imageModel = new Image();

            // Si c'est une image principale, supprimer l'ancienne avant d'insérer
            if ($isPrimary) {
                $existingImage = $imageModel->selectPrimaryImageByStampId($stampId);
                if ($existingImage) {
                    $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . $existingImage['url'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $imageModel->delete($existingImage['id']);
                }
            } else {
                // Vérifier si une image avec le même nom existe déjà pour éviter un conflit
                $existingImage = $imageModel->selectImageByNameAndStampId($originalName, $stampId);
                if ($existingImage) {
                    return false;
                }
            }
            $user = Auth::user();
            return $imageModel->insert([
                'stamp_id'   => $stampId,
                'name'       => $originalName,
                'url'        => ASSET . '/img/uploads/' . $user . "/" . $stampId . '/' . $fileName,
                'is_primary' => $isPrimary ? 1 : 0,
            ]);
        }
        return false;
    }
}