<?php

namespace bomi\mvcat\manifest\entities;

use Tebru\Gson\Annotation\SerializedName;

class Template {

	/** @SerializedName("name") */
	private $_name;
	public function getName() : string {
		return $this->_name;
	}
	
	/** @SerializedName("path") */
	private $_path;
	public function getPath() : string {
		return $this->_path;
	}
		
	/**  @SerializedName("variables")  */
	private $_variables;	
	public function getVariables() : array {
		return $this->_variables;
	}
	
	public function __construct() {
		$this->_variables = array();
	}
	
	/**
	 * add template value to the list
	 *
	 * @param string $name the key
	 * @param string $value the value
	 */
	public function addVariable(string $name, string $value): void {
		$this->_variables["\${" . $name . "}"] = $value;
	}
	
	public function __set($name, $value) {
		switch ($name) {
			case "name":
				$this->_name = $value;
				break;
			case "path":
				$this->_path = $value;
				break;
			case "variables":
				foreach ($value as $key => $v) {
					$this->addVariable($key, $v);
				}				
				break;
			default:
				break;
		}
	}
}

