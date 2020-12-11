<?php

namespace bomi\mvcat\exceptions;

class MvcNullReferenceException extends MvcException {

	public function __construct($reference, $code = null, $previous = null) {
		parent::__construct("$reference is not defined. Please check your configuration file", $code, $previous);
	}
}

