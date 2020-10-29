<?php
namespace bomi\mvcat\core\data\routing;
use Tebru\Gson\Annotation\SerializedName;

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
	 * @var array
	 * @SerializedName("catch")
	 */
	private $_catch;
	public function getCatch(): array {
		return $this->_catch;
	} 

	public function __construct() {}
}

