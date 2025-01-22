<?php

namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    protected $mailer;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($to, $subject, $body)
    {
        try {
            // Configuration du serveur SMTP
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.example.com'; // Remplacez par votre serveur SMTP
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'your_email@example.com'; // Remplacez par votre adresse email
            $this->mailer->Password = 'your_email_password'; // Remplacez par votre mot de passe
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;

            // Destinataires
            $this->mailer->setFrom('from@example.com', 'Mailer');
            $this->mailer->addAddress($to);

            // Contenu de l'email
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            $this->mailer->AltBody = strip_tags($body);

            if ($this->mailer->send()) {
                echo 'Message has been sent';
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}