<?php
namespace bomi\mvcat\manifest\entities;

use Tebru\Gson\Annotation\SerializedName;

class ParameterList {
	private $_controller;
	public function getController() {
		return $this->_controller;
	}
	
	private $_action;
	public function getAction() {
		return $this->_action;
	}

	/**  @SerializedName("parameters") */
	private $_parameters;
	public function getParameters() {
		return $this->_parameters;
	}

	public function __construct() {
		$this->_parameters = array ();
	}

	public function __set($name, $value) {
		switch($name){
			case "controller" :
				$this->_controller = $value;
				break;
			case "action" :
				$this->_action = $value;
				break;
			default:
				$this->_parameters[$name] = $value;
				break;
		}
	}

	public function __get($name) {
		if (isset($this->_parameters[$name])) {
			return $this->_parameters[$name];
		}
		return null;
	}
}

