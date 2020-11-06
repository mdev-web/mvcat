<?php

namespace bomi\mvcat\i18n;

class I18N {
	private array $_values;

	public function __construct(string $path = null) {
		$this->_values = $path === null ? array () : $this->_parse(file_get_contents($path));
		$this->get("my.demo.value", "one", "two", "three");
	}
	
	public function get($key, $agrs = null) {
		if (!key_exists($key, $this->_values)) {
			return $key;
		}
				
		$string = $this->_values[$key];
		foreach (func_get_args() as $key => $value) {
			if ($key > 0) {
				$string = str_replace("{" . $key . "}", $value, $string);
			}
		}
		$this->_values[$key] = $string;
	}

	private function _parse($content): array {
		$values = array();
		if (preg_match_all('/([a-zA-Z0-9\-_\.]*)=([^\r\n]*)/u', $content, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $gr) {
				$values[trim($gr[1])] = trim($gr[2]);
			}
		}
		return $values;
	}
}

