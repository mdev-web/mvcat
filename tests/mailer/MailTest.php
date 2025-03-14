<?php

namespace tests\mailer;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use shared\mailer\Mail;

class MailTest extends TestCase
{
    public function testCreateInstance()
    {
        $mail = new Mail();
        $this->assertInstanceOf(Mail::class, $mail);
    }

    public function testFromJsonValidData()
    {
        $json = json_encode([
        'userName' => "John Doe",
        'userEmail' => "john@example.com",
        'userPhone' => "+1234567890",
        'userMessage' => "Hello, this is a test message."
        ]);

        $mail = Mail::fromJson($json);

        $this->assertSame("John Doe", $mail->getUserName());
        $this->assertSame("john@example.com", $mail->getUserEmail());
        $this->assertSame("+1234567890", $mail->getUserPhone());
        $this->assertSame("Hello, this is a test message.", $mail->getUserMessage());
    }

    public function testFromJsonInvalidData()
    {
        $this->expectException(InvalidArgumentException::class);
        Mail::fromJson("invalid json string");
    }

    public function testFromJsonHandlesMissingFields()
    {
        $json = json_encode([
        'userName' => "Jane Doe",
        'userEmail' => "jane@example.com"
        ]);

        $mail = Mail::fromJson($json);

        $this->assertSame("Jane Doe", $mail->getUserName());
        $this->assertSame("jane@example.com", $mail->getUserEmail());
        $this->assertNull($mail->getUserPhone());
        $this->assertNull($mail->getUserMessage());
    }

    public function testToArray()
    {
        $json = json_encode([
        'userName' => "Alice",
        'userEmail' => "alice@example.com",
        'userPhone' => "9876543210",
        'userMessage' => "Test message"
        ]);

        $mail = Mail::fromJson($json);
        $arrayData = $mail->toArray();

        $expected = [
        'userName' => "Alice",
        'userEmail' => "alice@example.com",
        'userPhone' => "9876543210",
        'userMessage' => "Test message"
        ];

        $this->assertSame($expected, $arrayData);
    }
}
