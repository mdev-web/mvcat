<?php

namespace shared\exceptions;

use Exception;
use Throwable;

class InvalidMailDataException extends Exception
{
    public function __construct($message = "Invalid mail data", $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
