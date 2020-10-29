<?php
namespace bomi\mvcat\service;

use Exception;
use bomi\mvcat\base\Template;
use bomi\mvcat\context\MvcContext;

final class MvcBuilder {	
	private Mvc $_mvc;
	private $_exception = null;

	/** @var Template[] */
	private array $_templates;

	private function __construct() {
		$this->_templates = array ();
	}

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
			$a = MvcContext::get($configurationFile);
			$this->_mvc = Mvc::create($a);
		} catch (Exception $e) {
			$this->_exception = $e;
		} finally {
			return $this;
		}
	}

	public function template(string $name, Template $template): self {
		try {
			$this->_templates[$name] = $template;
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
			$this->_mvc->setTemplates($this->_templates);
			$this->_mvc->execute();
			return $callback(200);
		} catch (Exception $e) {
			return $callback(500, $e);
		}
	}
}
