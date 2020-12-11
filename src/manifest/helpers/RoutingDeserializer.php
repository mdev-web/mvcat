<?php

namespace bomi\mvcat\manifest\helpers;

use Tebru\Gson\JsonDeserializer;
use Tebru\PhpType\TypeToken;
use Tebru\Gson\JsonDeserializationContext;
use bomi\mvcat\manifest\entities\Route;
use bomi\mvcat\manifest\entities\ParameterList;
use bomi\mvcat\manifest\entities\Routing;

class RoutingDeserializer implements JsonDeserializer {

	public function __construct() {}

	public function deserialize($value, TypeToken $type, JsonDeserializationContext $context) {
		$routing = new Routing();
		$controller = !isset($value["controllers"]) ? "" : $value["controllers"];
		$controller->views = $value["views"];

		foreach ($value["routes"] as $route) {
			$route["parameters"]["controller"] = $controller . $route["parameters"]["controller"];
			$routing->addRoute($context->deserialize($route, Route::class));
		}
		return $routing;
	}
}

