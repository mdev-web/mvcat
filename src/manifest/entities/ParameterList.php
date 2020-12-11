<?php

namespace bomi\mvcat\manifest\entities;

use Tebru\Gson\Annotation\SerializedName;

class ParameterList {
	private const CONTROLLER_SFX = "Controller";
	private $_controller;

	public function getController() {
		return substr($this->_controller, - strlen(self::CONTROLLER_SFX)) === self::CONTROLLER_SFX 
				? $this->_controller 
				: $this->_controller . self::CONTROLLER_SFX;
	}
	private $_action;

	public function getAction() {
		return $this->_action;
	}

	/**
	 *
	 *  @SerializedName("parameters")
	 */
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
				$this->_controller = $this->_buildController($value);
				break;
			case "action" :
				$this->_action = $value;
				break;
			default:
				$this->_parameters[$name] = $value;
				break;
		}
	}

	private function _buildController($controller) {
		if ($this->_controller === null) {
			$controller = str_replace("\\", "/", $controller);
			$split = preg_split("/\//", $controller);
			$index = count($split) - 1;
			$split[$index] = ucfirst($split[$index]);
			return str_replace("/", "\\", implode("/", $split));
		} else if (substr($this->_controller, - 1) === "/" || substr($this->_controller, - 1) === "\\") {
			return $this->_controller . ucfirst($controller);
		}
		return $this->_controller;
	}
}

