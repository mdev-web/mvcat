<?php

namespace bomi\mvcat\i18n;

class I18N {
	private $_values;

	public function __construct(string $path = null) {
		$this->_values = $path === null ? array () : $this->_parse(file_get_contents($path));
	}
		
	public function get(string $key, array $args = []) {
		if (!key_exists($key, $this->_values)) {
			return $key;
		}
		
		$string = $this->_values[$key];
		for ($i = 0; $i < sizeof($args); $i++) {
			$string = str_replace("{" . ($i + 1) . "}", trim($args[$i]), $string);
		}
		return $string;
	}

	private function _parse($content): array {		
		$content = preg_replace("/\/\*[\s\S]*?\*\/|([^:]|^)\/\/.*$/im", "", $content);
		$content = preg_replace('/^\h*\v+/m', '',$content);
		
		$values = array();
		if (preg_match_all('/([a-zA-Z0-9\-_\. ]*)=([^\r\n]*)/u', $content, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $gr) {
				$values[trim($gr[1])] = trim($gr[2]);
			}
		}
		return $values;
	}
}

