<?php

namespace shared\exceptions;

use Exception;

class ConfigurationException extends Exception
{
    public function __construct($message, $code = 400, Exception $previous = null)
    {
        parent::__construct(sprintf("Configuration error: %s", $message), $code, $previous);
    }
}
