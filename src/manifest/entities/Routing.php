<?php
namespace bomi\mvcat\manifest\entities;
use Tebru\Gson\Annotation\SerializedName;

class Routing {
    
    /**
     * @var string
     * @SerializedName("views")
     */
    private $_viewsPath = "";
    public function getViewsPaht(): string {
        return $this->_viewsPath;
    }
	
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
	
	public function __set($name, $value) {
	    if ($name === "view") {
	        $this->_viewsPath = $value;
	    }
	}
}

