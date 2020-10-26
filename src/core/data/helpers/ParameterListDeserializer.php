<?php

namespace bomi\mvcat\core\data\helpers;

use Tebru\Gson\JsonDeserializer;
use Tebru\PhpType\TypeToken;
use Tebru\Gson\JsonDeserializationContext;
use bomi\mvcat\core\data\routing\ParameterList;

class ParameterListDeserializer implements JsonDeserializer {

	public function __construct() {}

	public function deserialize($value, TypeToken $type, JsonDeserializationContext $context) {
		$parameters = new ParameterList();
		foreach ($value as $key => $v) {
			$parameters->$key = $v;
		}
		return $parameters;
	}
}

