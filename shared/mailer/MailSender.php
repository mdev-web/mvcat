<?php

namespace shared\mailer;

use Exception;
use shared\exceptions\BaseMailException;
use shared\exceptions\ConfigurationException;
use shared\exceptions\InvalidMailDataException;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use TheSeer\Tokenizer\NamespaceUriException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class MailSender implements IMailSender
{
    private MailConfig $mailConfig;


    public function __construct(MailConfig $mailConfig)
    {
        $this->mailConfig = $mailConfig;
    }

  /**
   * @param string $dsn
   * @param Mail $model
   * @throws InvalidMailDataException|ConfigurationException
   * @throws BaseMailException
   */
    public function send(string $dsn, Mail $model): void
    {
        try {
            $this->ensureValidUser($model);
            $mailer = new Mailer(Transport::fromDsn($dsn));
            $mailer->send($this->rawMessage($model));
        } catch (InvalidMailDataException | ConfigurationException $e) {
            throw $e;
        } catch (TransportExceptionInterface | Exception $e) {
            throw new BaseMailException($e);
        }
    }

  /**
   * @param Mail $model
   * @throws InvalidMailDataException
   */
    private function ensureValidUser(Mail $model): void
    {
        if (
            empty($model->getUserName()) || empty($model->getUserMessage()) ||
            !filter_var($model->getUserEmail(), FILTER_VALIDATE_EMAIL)
        ) {
            throw new InvalidMailDataException();
        }
    }

  /**
   * @throws SyntaxError
   * @throws RuntimeError
   * @throws LoaderError
   */
    private function rawMessage(Mail $model): Email
    {
        $loader = new FilesystemLoader($this->mailConfig->getTemplatePath());
        $twig = new Environment($loader);

        $data = [
          Mail::NAME => $model->getUserName(),
          Mail::PHONE => $model->getUserPhone(),
          Mail::MSG => $model->getUserMessage(),
          Mail::EMAIL => $model->getUserEmail(),
          'currentDate' => date("d.m.Y H:i:s"),
        ];

        return (new Email())
        ->subject($this->mailConfig->getSubject())
        ->from($this->mailConfig->getFrom())
        ->to($this->mailConfig->getTo())
        ->bcc($this->mailConfig->getBcc())
        ->html($twig->render($this->mailConfig->getTemplateFile(), $data));
    }
}
