<?php
namespace bomi\mvcat\exceptions;

class FileNotFoundException extends MvcException {

	public function __construct($file, $code = null, $previous = null) {
		parent::__construct("File '$file' not found", $code, $previous);
	}
}

