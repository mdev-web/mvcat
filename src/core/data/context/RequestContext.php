<?php
namespace bomi\mvcat\core\data\context;

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
	
	private $_postData;
	public function getPostData() {
		return $this->_postData;
	}
	
	private function __construct() {
		$this->_method = $_SERVER["REQUEST_METHOD"];
		$this->_urlParameters = filter_input(INPUT_GET, "url", FILTER_SANITIZE_STRING);
		$this->_postData = empty($_POST) ? [] : $_POST;
	}
	
	public static function get() : self {
		return new self();
	}
}

