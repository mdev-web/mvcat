<?php
namespace bomi\mvcat\manifest;

use bomi\mvcat\exceptions\FileNotFoundException;
use bomi\mvcat\exceptions\JsonParsingException;
use Tebru\Gson\Gson;
use bomi\mvcat\manifest\helpers\ParameterListDeserializer;
use bomi\mvcat\manifest\helpers\RouteDeserializer;
use bomi\mvcat\manifest\entities\ParameterList;
use bomi\mvcat\manifest\entities\Route;
use bomi\mvcat\manifest\entities\Template;
use bomi\mvcat\manifest\helpers\TemplateDeserializer;

class ManifestReader {

	private function __construct() {}

	public static function read(string $manifestFile): Manifest {
		if (! file_exists($manifestFile)) {
			throw new FileNotFoundException($manifestFile);
		}

		$fileContent = file_get_contents($manifestFile);

		json_decode($fileContent);
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new JsonParsingException();
		}

		$gson = Gson::builder()
			->registerType(ParameterList::class, new ParameterListDeserializer())
			->registerType(Route::class, new RouteDeserializer())
			->registerType(Template::class, new TemplateDeserializer())
			->build();

		return $gson->fromJson($fileContent, Manifest::class);
	}
}

