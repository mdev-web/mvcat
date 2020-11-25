<?php
namespace bomi\mvcat\manifest\entities;
use Tebru\Gson\Annotation\SerializedName;
use Tebru\Gson\Context\ReaderContext;
use bomi\mvcat\context\RequestContext;

class Route {
	
	/** 
	 * @var string
	 * @SerializedName("path") 
	 */
	private $_path;
	public function getPath() : string {
		return $this->_path;
	}
	
	/**
	 * @var string[]
	 * @SerializedName("methods")
	 */
	private $_methods;
	public function getMethods() {
		return $this->_methods;
	}
	
	/** 
	 * @var ParameterList
	 * @SerializedName("parameters") 
	 */
	private $_parameters;
	public function getParameters() : ParameterList {
		return $this->_parameters;
	}
	
	public function __construct() {
		$this->_methods = [RequestContext::GET, RequestContext::POST, RequestContext::DELETE, RequestContext::PUT, RequestContext::OPTIONS];
	}
	
	public function __set($name, $value) {
		switch ($name) {
			case "path":
				$this->_path = $value;
				break;
			case "methods":
				$this->_methods = $value;
				break;
			default:
				$this->_parameters = $value;
				break;
		}
	}
}

