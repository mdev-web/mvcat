<?php
namespace bomi\mvcat\service;

use Exception;
use bomi\mvcat\context\MvcContext;

final class Mvcat {	
	private Mvc $_mvc;
	private $_exception = null;

	public static function build(string $configurationFile) : self {
		try {
			$obj = new self();
			$obj->_mvc = Mvc::create(MvcContext::get($configurationFile));
		} catch (Exception $e) {
			$obj->_exception = $e;
		} finally {
			return $obj;
		}
	}

	public function execute($callback) {
		if ($this->_exception !== null) {
			return $callback($this->_exception->getCode(), $this->_exception);
		} else {
			return $this->_execute($callback);
		}
	}

	private function _execute($callback) {
		try {
			$this->_mvc->execute();
			return $callback(200);
		} catch (Exception $e) {
			return $callback(500, $e);
		}
	}
}
