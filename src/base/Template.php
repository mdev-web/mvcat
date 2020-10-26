<?php

namespace bomi\mvcat\base;

class Template {	
	protected string $_file;
	protected array $_values;
	public function __construct(string $file) {
		$this->_file = $file;
		$this->_values = [];
	}
	
	public function getFile() : string {
		return $this->_file;
	}
	
	public function getValues() : array {
		return $this->_values;
	}
	
	/**
	 * set template values
	 * @param array $values [string, string] 
	 */
	public function setValues(array $values) : void {
		foreach ($values as $name => $value) {
			$this->addValue($name, $value);
		}
	}
	
	/**
	 * add template value to the list
	 * 
	 * @param string $name the key 
	 * @param string $value the value
	 */
	public function addValue(string $name, string $value): void {
		$this->_values["\${" . $name . "}"] = $value;
	}
}
