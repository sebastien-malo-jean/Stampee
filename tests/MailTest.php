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

        $this->expectOutputString('Message has been sent');
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

        $this->expectOutputString('Message could not be sent. Mailer Error: ');
    }
}