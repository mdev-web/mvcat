<?php
namespace bomi\mvcat\exceptions;

class MvcException extends \Exception {

	public function __construct($message = null, $code = null, $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}

