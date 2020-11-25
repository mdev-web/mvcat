<?php
namespace bomi\mvcat\context;

use bomi\mvcat\manifest\ManifestReader;
use bomi\mvcat\manifest\Manifest;

class MvcContext {

	private $_requestContext;
	public function getRequestContext() : RequestContext {
		return $this->_requestContext;
	}
	
	private $_manifestContext;
	public function getManifestContext() : ManifestContext {
		return $this->_manifestContext;
	}
	
	private function __construct(Manifest $manifest) {
		$this->_requestContext = RequestContext::get();
		$this->_manifestContext = ManifestContext::create($manifest, $this->_requestContext);
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

