<?php

namespace bomi\mvcat\manifest\entities;

use Tebru\Gson\Annotation\SerializedName;

class Template {

	/** @SerializedName("name") */
	private $_name;
	public function getName() {
		return $this->_name;
	}
	
	/** @SerializedName("path") */
	private $_path;
	public function getPath() {
		return $this->_path;
	}
		
	/**  @SerializedName("variables")  */
	private $_variables;	
	public function getVariables() {
		return $this->_variables;
	}
	
	public function __construct() {
		$this->_variables = array ();
	}
}

