<?php

namespace shared\mailer;

use shared\exceptions\ConfigurationException;
use Symfony\Component\Mime\Address;

class MailConfig
{
    private string $subject;
    private Address $from;
    private Address $to;
    private ?Address $bcc;
    private string $templatePath;
    private string $templateFile;

    private function __construct(
        string $subject,
        array $from,
        array $to,
        array $bcc,
        string $templatePath,
        string $templateFile
    ) {
        $this->subject = $subject;
        $this->from = new Address($from[0], $from[1] == null ? '' : $from[1]);
        $this->to = new Address($to[0], $to[1] == null ? '' : $to[1]);
        $this->bcc = null;
        if ($bcc[0] != null) {
            $this->bcc = new Address($bcc[0], $bcc[1] == null ? '' : $bcc[1]);
        }
        $this->templatePath = $templatePath;
        $this->templateFile = $templateFile;
    }

  /**
   * @throws ConfigurationException
   */
    public static function fromArray(array $config): self
    {
        if (
            empty($config['subject']) || empty($config['templatePath']) || empty($config['templateFile']) ||
            empty($config['from']) || empty($config['from']["email"]) ||
            empty($config['to']) ||  empty($config['to']["email"])
        ) {
            throw new ConfigurationException("Missing required email configuration fields.");
        }

        return new self(
            $config['subject'],
            [$config['from']['email'], $config['from']['label']],
            [$config['to']['email'], $config['to']['label']],
            [$config['bcc']['email'], $config['bcc']['label']],
            $config['templatePath'],
            $config['templateFile']
        );
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getFrom(): Address
    {
        return $this->from;
    }

    public function getTo(): Address
    {
        return $this->to;
    }

    public function getBcc(): ?Address
    {
        return $this->bcc;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function getTemplateFile(): string
    {
        return $this->templateFile;
    }
}
