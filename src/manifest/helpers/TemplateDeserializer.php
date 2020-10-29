<?php

namespace bomi\mvcat\manifest\helpers;

use Tebru\Gson\JsonDeserializer;
use Tebru\PhpType\TypeToken;
use Tebru\Gson\JsonDeserializationContext;
use bomi\mvcat\manifest\entities\Route;
use bomi\mvcat\manifest\entities\ParameterList;
use bomi\mvcat\manifest\entities\Template;

class TemplateDeserializer implements JsonDeserializer {

	public function __construct() {}

	public function deserialize($value, TypeToken $type, JsonDeserializationContext $context) {
		$template = new Template();
		foreach ($value as $key => $v) {
			$template->$key = $v;
		}
		return $template;
	}
}

