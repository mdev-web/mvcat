<?php

namespace bomi\mvcat\core\manifest\helpers;

use Tebru\Gson\JsonDeserializer;
use Tebru\PhpType\TypeToken;
use Tebru\Gson\JsonDeserializationContext;
use bomi\mvcat\core\manifest\ParameterList;
use bomi\mvcat\core\manifest\Route;

class RouteDeserializer implements JsonDeserializer {

	public function __construct() {}

	public function deserialize($value, TypeToken $type, JsonDeserializationContext $context) {
		$route = new Route();
		$path = null;
		$parameters = array();
		
		foreach ($value as $key => $v) {
			switch ($key) {
				case "path":
					$path = $v;
					break;
				case "parameters":
					$parameters = $v;
					break;	
				default:
					$route->$key = $v;
					break;
			}
		}
		
		
		$route->path = $this->_replacePath($path);
		$route->parameters = $context->deserialize($parameters, ParameterList::class);
		
		return $route;
	}

	private function _replacePath(string $path): string {
		$path = preg_replace('/\//', '\\/', $path);
		$path = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $path);
		$path = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $path);
		return  '/^' . $path . '$/i';
	}
}

