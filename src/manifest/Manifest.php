<?php
namespace bomi\mvcat\manifest;
use Tebru\Gson\Annotation\SerializedName;
use bomi\mvcat\manifest\entities\Route;
use bomi\mvcat\manifest\entities\Template;
use bomi\mvcat\manifest\entities\Data;
use bomi\mvcat\manifest\entities\I18N;

class Manifest {
	
	/** @SerializedName("version") */
	private $_version;

	/** 
	 * @var string[]
	 * @SerializedName("destinations") 
	 */
	private $_destinations = array();
	public function getDestinations() : array {
		return $this->_destinations;
	}
	
	/** 
	 * @var Route[]
	 * @SerializedName("routes") 
	 */
	private $_routes = array();
	public function getRoutes(): array {
		return $this->_routes;
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
		return $this->_data;
	} 
	
	/**
	 * @var I18N
	 * @SerializedName("i18n")
	 */
	private $_18n;
	public function getI18N(): I18N {
		return $this->_18n;
	} 

	public function __construct() {}
}

