<?php
namespace bomi\mvcat\context;

use bomi\mvcat\exceptions\MvcException;
use bomi\mvcat\manifest\Manifest;
use bomi\mvcat\manifest\entities\Route;
use bomi\mvcat\manifest\entities\Template;

class ManifestContext {
	
	private string $_controller;
	public function getController() : string {
		return $this->_controller;
	}
	
	private string $_action;
	public function getAction() : string {
		return $this->_action;
	}
	
	private array $_parameters;
	public function getParameters() : array {
		return $this->_parameters;
	}
	
	private RequestContext $_requestContext;
	public function getRequestContext() : RequestContext {
		return $this->_requestContext;
	}
	
	private string $_viewsDestination;
	public function getViewsDestination() : string {
		return $this->_viewsDestination;
	}
	
	private array $_templates = [];
	public function getTemplates(): array {
		return $this->_templates;
	}

	private function __construct(Route $route, Manifest $manifest, RequestContext $requestContext) {
		$this->_requestContext = $requestContext;
		$this->_controller = $this->_buildController($route, $manifest->getDestinations());
		$this->_action = $route->getParameters()->getAction();
		$this->_parameters = $route->getParameters()->getParameters();
		$this->_viewsDestination = $manifest->getDestinations()["views"];
		$this->_setTemplates($manifest->getTemplates());
	}
	
	public static function create(Manifest $manifest, RequestContext $requestContext) {
		foreach ($manifest->getRoutes() as $route) {
			if (in_array($requestContext->getMethod(), $route->getMethods())  && self::_match($requestContext->getUrlParameters(), $route)) {
				return new self($route, $manifest, $requestContext);
			}
		}
	 	throw new MvcException("Requested url '{$requestContext->getUrlParameters()}' is not part of routing.", 404);
	}
	
	private static function _match(string $urlParameters, Route $route) : bool {
		if (preg_match($route->getPath(), $urlParameters, $matches)) {
			foreach ($matches as $key => $match) {
				if (is_string($key)) {
					$route->getParameters()->$key = $match;
				}
			}
			return true;
		}
		return false;
	}
	
	private function _buildController(Route $route, array $destinations) {
		$controller = str_replace("\\", "/", $route->getParameters()->getController());
		$split = preg_split("/\//", $controller);
		$index = count($split) - 1;
		$split[$index] = ucfirst($split[$index]);
		return str_replace("/", "\\", $destinations["controllers"] . implode("/", $split));
	}
	
	/**
	 * 
	 * @param Template[] $templates
	 */
	private function _setTemplates(array $templates) {		
		/** @var Template $template */
		foreach ($templates as $template) {
			$this->_templates[$template->getName()] = $template;
		}
		
	}
}

