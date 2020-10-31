<?php
namespace bomi\mvcat\service;

use Exception;
use bomi\mvcat\context\MvcContext;

final class Mvcat {	
	private Mvc $_mvc;
	private $_exception = null;

	public static function build() : self {
		return new self();
	}

	/**
	 *
	 * @param string $configurationFile
	 *        	url to configuration file
	 * @return Mvc instance
	 */
	public function configure(string $configurationFile): self {
		try {
			$this->_mvc = Mvc::create(MvcContext::get($configurationFile));
		} catch (Exception $e) {
			$this->_exception = $e;
		} finally {
			return $this;
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
