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

    public function checkEmail($email){
    $user = $this->unique('email', $email);
    if($user){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; // Utilisez le serveur SMTP de Mailtrap
            $mail->SMTPAuth = true;
            $mail->Username = '2e62c38040480c'; // Remplacez par votre nom d'utilisateur Mailtrap
            $mail->Password = '9b15b292b94d06'; // Remplacez par votre mot de passe Mailtrap
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 2525;
            $mail->setFrom('from@example.com'); // Remplacez par une adresse email fictive
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = 'Click on the link to reset your password';
            $mail->AltBody = 'Click on the link to reset your password';
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    } else {
        return false;
    }
}
}