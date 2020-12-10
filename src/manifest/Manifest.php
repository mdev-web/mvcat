<?php
namespace bomi\mvcat\manifest;
use Tebru\Gson\Annotation\SerializedName;
use bomi\mvcat\manifest\entities\Route;
use bomi\mvcat\manifest\entities\Template;
use bomi\mvcat\manifest\entities\Data;
use bomi\mvcat\manifest\entities\I18N;
use bomi\mvcat\manifest\entities\Routing;

class Manifest {

	/**
	 * @var array
	 * @SerializedName("globals")
	 */
	private $_globals = array();
	public function getGlobals() : array {
	    return $this->_globals;
	}
	
	/** 
	 * @var string[]
	 * @SerializedName("destinations") 
	 */
	private $_destinations = array();
	public function getDestinations() : array {
		return $this->_destinations;
	}
	
	/**
	 * @var Routing
	 * @SerializedName("routing")
	 */
	private $_routing;
	public function getRouting(): Routing {
		return $this->_routing;
	} 
		
	/**
	 * @var Template[]
	 * @SerializedName("templates")
	 */
	private $_templates = array();
	public function getTemplates(): array {
		return $this->_templates;
	} 
	
	/**
	 * @var Data
	 * @SerializedName("data")
	 */
	private $_data;
	public function getData(): Data {
		if ($this->_data == null) {
			return new Data();
		}
		return $this->_data;
	} 
	
	/**
	 * @var I18N
	 * @SerializedName("i18n")
	 */
	private $_i18n;
	public function getI18N(): I18N {
		if ($this->_i18n === null) {
			return new I18N();
		}
		return $this->_i18n;
	} 

	public function __construct() {}
}

