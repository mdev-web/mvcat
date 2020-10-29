<?php
namespace bomi\mvcat\core\data\context;

use bomi\mvcat\exceptions\MvcException;
use bomi\mvcat\manifest\entities\Manifest;
use bomi\mvcat\manifest\entities\Route;

class RouteContext {
	
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

	private function __construct(Route $route, Manifest $routeMap, RequestContext $requestContext) {
		$this->_requestContext = $requestContext;
		$this->_controller = $this->_buildController($route, $routeMap->getDestinations());
		$this->_action = $route->getParameters()->getAction();
		$this->_parameters = $route->getParameters()->getParameters();
		$this->_viewsDestination = $routeMap->getDestinations()["views"];
	}
	
	public static function create(Manifest $routeMap, RequestContext $requestContext) {
		foreach ($routeMap->getRoutes() as $route) {
			if (in_array($requestContext->getMethod(), $route->getMethods())  && self::_match($requestContext->getUrlParameters(), $route)) {
				return new self($route, $routeMap, $requestContext);
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
}

