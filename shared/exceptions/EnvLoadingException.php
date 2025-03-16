<?php

namespace shared\exceptions;

use Throwable;

class EnvLoadingException extends \Exception
{
    public function __construct(string $envFile, Throwable $previous = null)
    {
        $message = sprintf("An error occurred while loading the environment file '%s'.", $envFile);
        parent::__construct($message, 400, $previous);
    }
}
