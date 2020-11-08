<?php
namespace bomi\mvcat\context;

class RequestContext {
	public const GET = "GET";
	public const POST = "POST";
	public const PUT = "PUT";
	public const DELETE = "DELETE";
	public const OPTIONS = "OPTIONS";
	
	private $_method;
	public function getMethod() {
		return $this->_method;
	}
	
	private $_urlParameters;
	public function getUrlParameters() : string {
		return isset($this->_urlParameters) ? $this->_urlParameters : '/';
	}
	
	private array $_postData;
	public function getPostData() {
		return $this->_postData;
	}
	
	private function __construct() {
		$this->_method = $_SERVER["REQUEST_METHOD"];
		$this->_urlParameters = filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING|FILTER_SANITIZE_SPECIAL_CHARS);
		$this->_postData = array(); 
		if (!empty($_POST)) {
			foreach ($_POST as $key => $value) {
				$this->_postData[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		var_dump($this->_postData);
	}
	
	public static function get() : self {
		return new self();
	}
}

