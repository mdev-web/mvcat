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
		$suffix = "Controller";
		$controller = str_replace("\\", "/", $controller);
		$split = preg_split("/\//", $controller);
		$index = count($split) - 1;
		$split[$index] = ucfirst($split[$index]);
		$controller =  str_replace("/", "\\", implode("/", $split));

		return substr($controller, -strlen($suffix)) === $suffix ? $controller : $controller . $suffix;
	}
}

