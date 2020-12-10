<?php
namespace bomi\mvcat\manifest\entities;
use Tebru\Gson\Annotation\SerializedName;

class Routing {
	
	/**
	 * @var Route[]
	 * @SerializedName("routes")
	 */
	private $_routes = array();
	public function getRoutes(): array {
		return $this->_routes;
	} 
	public function addRoute($route) {
		array_push($this->_routes, $route);
	}
}

