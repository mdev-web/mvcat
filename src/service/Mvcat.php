<?php
namespace bomi\mvcat\service;

use Exception;
use bomi\mvcat\context\MvcContext;
use bomi\mvcat\exceptions\MvcException;

final class Mvcat {	
	private $_mvc = null;
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
	
	public function language($lang = null) {
		if ($this->_mvc != null) {
			$this->_mvc->setLanguage($lang);
		}
		return $this;
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
			if ($this->_mvc != null) { 				
				$this->_mvc->execute();
				return $callback(200);
			} else {
				return $callback(500, new MvcException("An unknown error has occurred"));
			}
		} catch (Exception $e) {
			return $callback($e->getCode(), $e);
		}
	}
}
