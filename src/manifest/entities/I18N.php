<?php

namespace bomi\mvcat\manifest\entities;

use Tebru\Gson\JsonDeserializationContext;
use Tebru\Gson\JsonDeserializer;
use Tebru\PhpType\TypeToken;

class I18N {
	
	/**
	 * @var string
	 * @SerializedName("folder")
	 */
	private $_folder;
	public function getFolder() {
		return $this->_folder;
	}

	/**
	 * @var string
	 * @SerializedName("default")
	 */
	private $_default;
	public function getDefault(): ?string {
		if ($this->_default === null) {
			return $this->_default;
		}
		return $this->_folder . $this->_default;
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
		$this->_default = null;
		$this->_languages = array();
	}
	
	public function __set($name, $value) {
		$this->{"_" . $name} = $value;
	}
	
	public function updateLangueages() {
		foreach ($this->_languages as $key => $v) {
			$this->setLanguage($key, $this->_folder . $v);
		}
	}
}

