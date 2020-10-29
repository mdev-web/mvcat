<?php
namespace bomi\mvcat\context;

use bomi\mvcat\manifest\ManifestReader;
use bomi\mvcat\manifest\entities\Manifest;

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

