<?php 
use PHPUnit\Framework\TestCase;
use App\Models\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailTest extends TestCase
{
    public function testSendEmailSuccess()
    {
        $to = 'test@example.com';
        $subject = 'Test Subject';
        $body = 'Test Body';

        $mockMailer = $this->createMock(PHPMailer::class);
        $mockMailer->expects($this->once())->method('send')->willReturn(true);

        $mail = new Mail($mockMailer);
        $mail->sendEmail($to, $subject, $body);

        $this->expectOutputString('Le message à été envoyer avec succès!');
    }

    public function testSendEmailFailure()
    {
        $to = 'test@example.com';
        $subject = 'Test Subject';
        $body = 'Test Body';

        $mockMailer = $this->createMock(PHPMailer::class);
        $mockMailer->expects($this->once())->method('send')->will($this->throwException(new Exception('SMTP Error')));

        $mail = new Mail($mockMailer);
        $mail->sendEmail($to, $subject, $body);

        $this->expectOutputString("Le message n'a pas pu être envoyé. Erreur du serveur SMTP: SMTP Error: ");
    }
}