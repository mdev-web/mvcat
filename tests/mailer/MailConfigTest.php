<?php

namespace tests\mailer;

use PHPUnit\Framework\TestCase;
use shared\exceptions\ConfigurationException;
use shared\mailer\MailConfig;

class MailConfigTest extends TestCase
{
  /**
   * @throws ConfigurationException
   */
    public function testFromArrayFullHappy()
    {
        $testConfig = [
          'subject' => 'Test Email',
          'templatePath' => '/templates/emails',
          'templateFile' => 'welcome.html',
          'from' => [
            'email' => 'sender@example.com',
            'label' => 'Sender Name'
          ],
          'to' => [
            'email' => 'recipient@example.com',
            'label' => 'Recipient Name'
          ],
          'bcc' => [
            'email' => 'bcc@example.com',
            'label' => 'BCC Name'
          ]
        ];

        $mailConfig = MailConfig::fromArray($testConfig);
        $this->assertInstanceOf(MailConfig::class, $mailConfig);
        $this->assertEquals('Test Email', $mailConfig->getSubject());
        $this->assertEquals('/templates/emails', $mailConfig->getTemplatePath());
        $this->assertEquals('welcome.html', $mailConfig->getTemplateFile());
        $this->assertEquals('sender@example.com', $mailConfig->getFrom()->getAddress());
        $this->assertEquals('Sender Name', $mailConfig->getFrom()->getName());
        $this->assertEquals('recipient@example.com', $mailConfig->getTo()->getAddress());
        $this->assertEquals('Recipient Name', $mailConfig->getTo()->getName());
        $this->assertEquals('bcc@example.com', $mailConfig->getBcc()->getAddress());
        $this->assertEquals('BCC Name', $mailConfig->getBcc()->getName());
    }
}
