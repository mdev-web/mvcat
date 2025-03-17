<?php

namespace shared\exceptions;

use Exception;
use Throwable;

class ConfigurationException extends Exception
{
    public function __construct($message, $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(sprintf("Configuration error: %s", $message), $code, $previous);
    }
}
