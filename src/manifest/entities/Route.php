<?php
namespace bomi\mvcat\manifest\entities;
use Tebru\Gson\Annotation\SerializedName;
use bomi\mvcat\core\data\context\RequestContext;
use Tebru\Gson\Context\ReaderContext;

class Route {
	
	/** 
	 * @var string
	 * @SerializedName("path") 
	 */
	private string $_path;
	public function getPath() : string {
		return $this->_path;
	}
	
	/**
	 * @var string[]
	 * @SerializedName("methods")
	 */
	private array $_methods;
	public function getMethods() {
		return $this->_methods;
	}
	
	/** 
	 * @var ParameterList
	 * @SerializedName("parameters") 
	 */
	private ParameterList $_parameters;
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

