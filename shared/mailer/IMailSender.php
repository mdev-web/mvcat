<?php

namespace shared\mailer;

use shared\exceptions\BaseMailException;
use shared\exceptions\InvalidMailDataException;

interface IMailSender
{
  /**
   * @param string $dsn
   * @param Mail $model
   * @throws InvalidMailDataException
   * @throws BaseMailException
   */
    public function send(string $dsn, Mail $model): void;
}
