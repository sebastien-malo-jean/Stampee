<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\UserController;
use App\Models\User;
use App\Models\PrivilegeInterface;
use App\Providers\View;
use App\Providers\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\Mail;

// Inclure le fichier de configuration
require_once __DIR__ . '/../config.php';

class UserControllerTest extends TestCase
{
    public function testStoreSuccess()
    {
        // Mock the dependencies
        $mockUser = $this->createMock(User::class);
        $mockUser->method('insert')->willReturn(1); // Simulate successful insert
        $mockUser->method('hashPassword')->willReturn('hashed_password');
        $mockUser->method('generateValidationLink')->willReturn('https://yourdomain.com/validate?user=1&token=token');

        $mockMailer = $this->createMock(PHPMailer::class);
        $mockMailer->expects($this->once())->method('send')->willReturn(true);

        $mockMail = $this->getMockBuilder(Mail::class)
                         ->setConstructorArgs([$mockMailer])
                         ->onlyMethods(['sendEmail'])
                         ->getMock();

        $mockMail->expects($this->once())->method('sendEmail')->willReturnCallback(function() {
            echo 'Message has been sent';
        });

        $mockValidator = $this->createMock(Validator::class);
        $mockValidator->method('isSuccess')->willReturn(true);

        $mockPrivilege = $this->createMock(PrivilegeInterface::class);
        $mockPrivilege->method('select')->willReturn(['privilege1', 'privilege2']);

        // Inject the mocks into the controller
        $controller = new UserController();
        $controller->user = $mockUser;
        $controller->validator = $mockValidator;
        $controller->privilege = $mockPrivilege;
        $controller->mail = $mockMail;

        // Simulate form data
        $data = [
            'name' => 'Test User',
            'username' => 'testuser',
            'password' => 'password123',
            'email' => 'test@example.com',
            'privilege_id' => 1
        ];

        // Start output buffering
        ob_start();

        // Call the store method
        $controller->store($data);

        // Get the output
        $output = ob_get_clean();

        // Assert that the email was sent
        $this->assertStringContainsString('Message has been sent', $output);
    }

    public function testStoreValidationFailure()
    {
        // Mock the dependencies
        $mockValidator = $this->createMock(Validator::class);
        $mockValidator->method('isSuccess')->willReturn(false);
        $mockValidator->method('getErrors')->willReturn(['Validation failed']);

        $mockPrivilege = $this->createMock(PrivilegeInterface::class);
        $mockPrivilege->method('select')->willReturn(['privilege1', 'privilege2']);

        // Inject the mocks into the controller
        $controller = new UserController();
        $controller->validator = $mockValidator;
        $controller->privilege = $mockPrivilege;

        // Simulate form data
        $data = [
            'name' => 'Test User',
            'username' => 'testuser',
            'password' => 'password123',
            'email' => 'test@example.com',
            'privilege_id' => 1
        ];

        // Start output buffering
        ob_start();

        // Call the store method
        $controller->store($data);

        // Get the output
        $output = ob_get_clean();

        // Assert that the validation errors are returned
        $this->assertStringContainsString('Le format de Username est invalide.', $output);
        $this->assertStringContainsString('Email doit correspondre à testuser.', $output);
    }
}