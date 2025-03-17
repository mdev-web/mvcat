<?php

namespace shared\exceptions;

use Exception;
use Throwable;

class BaseMailException extends Exception
{
    public function __construct(Exception $e)
    {
        parent::__construct($e->getMessage(), $e->getCode() == 0 ? 500 : $e->getCode(), $e);
    }
}
