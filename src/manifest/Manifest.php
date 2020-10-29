<?php
namespace bomi\mvcat\manifest;
use Tebru\Gson\Annotation\SerializedName;
use bomi\mvcat\manifest\entities\Route;
use bomi\mvcat\manifest\entities\Template;

class Manifest {
	
	/** @SerializedName("version") */
	private $_version;

	/** 
	 * @var string[]
	 * @SerializedName("destinations") 
	 */
	private $_destinations;
	public function getDestinations() : array {
		return $this->_destinations;
	}
	
	/** 
	 * @var Route[]
	 * @SerializedName("routes") 
	 */
	private $_routes;
	public function getRoutes(): array {
		return $this->_routes;
	} 
	
	/**
	 * @var Template[]
	 * @SerializedName("templates")
	 */
	private $_templates;
	public function getTemplates(): array {
		return $this->_templates;
	} 

	public function __construct() {}
}

