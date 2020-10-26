<?php
namespace bomi\mvcat\exceptions;

class JsonParsingException extends MvcException {

	public function __construct($code = null, $previous = null) {
		parent::__construct("Error occured by parsing of json", $code, $previous);
	}
}

