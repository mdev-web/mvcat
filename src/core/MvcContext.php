<?php
namespace bomi\mvcat\core;

use bomi\mvcat\core\data\context\RequestContext;
use bomi\mvcat\core\data\context\RouteContext;
use bomi\mvcat\service\ManifestReader;
use bomi\mvcat\core\manifest\Manifest;

class MvcContext {

	private RequestContext $_requestContext;
	public function getRequestContext() : RequestContext {
		return $this->_requestContext;
	}
	
	private RouteContext $_routeContext;
	public function getRouteContext() : RouteContext {
		return $this->_routeContext;
	}
	
	private function __construct(Manifest $manifest) {
		$this->_requestContext = RequestContext::get();
		$this->_routeContext = RouteContext::create($manifest, $this->_requestContext);
	}
	
	/**
	 * 
	 * @param string $manifestFile
	 * @return self
	 */
	public static function get(string $manifestFile) : self {
		return new self(ManifestReader::read($manifestFile));
	}
}

