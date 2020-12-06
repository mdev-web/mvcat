<?php

namespace bomi\mvcat\manifest\entities;

use Tebru\Gson\JsonDeserializationContext;
use Tebru\Gson\JsonDeserializer;
use Tebru\PhpType\TypeToken;

class I18N implements JsonDeserializer {
	
	/**
	 * @var string
	 * @SerializedName("folder")
	 */
	private $_folder;

	/**
	 * @var string
	 * @SerializedName("default")
	 */
	private $_default;
	public function getDefault(): string {
		return $this->_default;
	}
	
	/**
	 * @var array
	 * @SerializedName("languages")
	 */
	private $_languages;
	public function getLanguages(): array {
		return $this->_languages;
	}

	public function __construct() {
		$this->_folder = "";
		$this->_default = "";
		$this->_languages = array();
	}
	
	public function deserialize($value, TypeToken $type, JsonDeserializationContext $context) {
		foreach ($value as $key => $v) {
			$this->{"_" . $key} = $v;
		}
		
		foreach ($this->_languages as $key => $v) {
			$this->_languages[$key] = $this->_folder . $v;
		}
		
		return $this;
	}
}

