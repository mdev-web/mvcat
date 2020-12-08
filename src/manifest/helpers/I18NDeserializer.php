<?php

namespace bomi\mvcat\manifest\helpers;

use Tebru\Gson\JsonDeserializationContext;
use Tebru\Gson\JsonDeserializer;
use Tebru\PhpType\TypeToken;
use bomi\mvcat\manifest\entities\I18N;

class I18NDeserializer implements JsonDeserializer {
	
	public function deserialize($value, TypeToken $type, JsonDeserializationContext $context) {
		$i18n = new I18N();
		foreach ($value as $key => $v) {
			$i18n->$key = $v;
		}
		
		return $i18n;
	}
}

