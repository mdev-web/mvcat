<?php

namespace bomi\mvcat\core;

use bomi\mvcat\exceptions\FileNotFoundException;
use bomi\mvcat\exceptions\JsonParsingException;
use Tebru\Gson\Gson;
use bomi\mvcat\core\data\routing\RouteMap;
use bomi\mvcat\core\data\routing\ParameterList;
use bomi\mvcat\core\data\helpers\ParameterListDeserializer;
use bomi\mvcat\core\data\routing\Route;
use bomi\mvcat\core\data\helpers\RouteDeserializer;

class RouteMapReader {
	
	private $_configuration;

	private function __construct() { }
	
	public static function read(string $configurationFile) : RouteMap  {
		if (!file_exists($configurationFile)) {
			throw new FileNotFoundException($configurationFile);
		}
		
		$fileContent = file_get_contents($configurationFile);
		
		json_decode($fileContent);
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new JsonParsingException();
		}

		$gson = Gson::builder()
				->registerType(ParameterList::class, new ParameterListDeserializer())
				->registerType(Route::class, new RouteDeserializer())
				->build();
		
		return $gson->fromJson($fileContent, RouteMap::class);
	}
}

