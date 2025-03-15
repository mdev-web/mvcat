<?php

namespace shared\mailer;

use Symfony\Component\Mailer\Mailer;

interface IMailSender
{
    public function send(string $dsn, Mail $model): void;
}
