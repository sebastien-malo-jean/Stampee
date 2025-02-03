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

        // Créer le répertoire s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $tmpName = $file['tmp_name'];
        $originalName = basename($file['name']);

        // Renommer l'image pour éviter les conflits
        $fileName = $stampId . '_' . time() . '_' . uniqid() . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
        $destination = $uploadDir . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));

        // Vérifier le type de fichier et le déplacer
        if (in_array($imageFileType, $allowedTypes) && move_uploaded_file($tmpName, $destination)) {
            $imageModel = new Image();

            // Si c'est une image principale, supprimer l'ancienne avant d'insérer
            if ($isPrimary) {
                $existingImage = $imageModel->selectPrimaryImageByStampId($stampId);
                if ($existingImage) {
                    $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . $existingImage['url'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Supprimer l'ancienne image
                    }
                    $imageModel->delete($existingImage['id']); // Supprimer l'entrée en base de données
                }
            } else {
                // Pas besoin de vérifier si une image avec le même nom existe
                // On renomme l'image avec un identifiant unique, donc il n'y aura pas de conflit
            }

            // Enregistrer l'image dans la base de données
            return $imageModel->insert([
                'stamp_id'   => $stampId,
                'name'       => $originalName,
                'url'        => ASSET . '/img/uploads/' . $user . "/" . $stampId . '/' . $fileName,
                'is_primary' => $isPrimary ? 1 : 0,
            ]);
        }

        return false; // Retourner false si l'upload échoue
    }
}