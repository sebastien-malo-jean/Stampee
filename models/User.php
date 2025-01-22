<?php
namespace App\Models;
use App\Models\CRUD;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class User extends CRUD{
    protected $table = "user";
    protected $primaryKey = "id";
    protected $fillable = ['name', 'username', 'password', 'email', 'privilege_id'];

    public function hashPassword($password, $cost = 10){
        $options = [
            'cost' => $cost
        ];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function checkUser($username, $password){
    $user = $this->unique('username', $username);
    if($user){
        if(password_verify($password, $user['password'])){
            session_regenerate_id();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['privilege_id'] = $user['privilege_id'];
            $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
    }

    public static function generateValidationLink($userId){
        $token = bin2hex(random_bytes(16)); // Génère un token de validation
        return "https://yourdomain.com/validate?user=$userId&token=$token";
    }

        public static function createUser($email, $name) {
        // Logique pour créer un utilisateur dans la base de données
        $userId = // ID de l'utilisateur créé

        // Générer un lien de validation
        $validationLink = self::generateValidationLink($userId);

        // Envoyer l'email de validation
        $mailer = new PHPMailer(true);
        $mail = new Mail($mailer);
        $subject = "Bienvenue $name !";
        $body = "Bonjour $name,\n\nCliquez sur le lien suivant pour valider votre email : $validationLink";

        $mail->sendEmail($email, $subject, $body);

        // Retourner l'utilisateur créé ou d'autres informations nécessaires
        return $userId;
    }

}