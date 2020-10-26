<?php
namespace bomi\mvcat\core;

use bomi\mvcat\core\data\routing\RouteMap;
use bomi\mvcat\core\data\context\RequestContext;
use bomi\mvcat\core\data\context\RouteContext;

class MvcContext {

	private RequestContext $_requestContext;
	public function getRequestContext() : RequestContext {
		return $this->_requestContext;
	}
	
	private RouteContext $_routeContext;
	public function getRouteContext() : RouteContext {
		return $this->_routeContext;
	}
	
	private function __construct(RouteMap $routeMap) {
		$this->_requestContext = RequestContext::get();
		$this->_routeContext = RouteContext::create($routeMap, $this->_requestContext);
	}
	
	/**
	 * 
	 * @param string $configurationFile
	 * @return self
	 */
	public static function get(string $configurationFile) : self {
		return new self(RouteMapReader::read($configurationFile));
	}
}

