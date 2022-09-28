<?php

namespace bomi\mvcat\base;

use bomi\mvcat\manifest\entities\Template;
use bomi\mvcat\exceptions\FileNotFoundException;
use bomi\mvcat\i18n\I18NService;

class View {
	public const VIEW_RENDER = "viewRender";
	private const SEPARATOR = ">>";

	private $_i18n;

	public public public function __construct() {}
	
	public function setI18N(I18NService $i18n) {
		$this->_i18n = $i18n;
	}
	
	public function template(string $viewPath, array $data = array(), Template $template = null) {
		$view = $this->view($viewPath, $data);
		if ($template === null) {
			return $view;
		}
		$data[self::VIEW_RENDER] = $view;
		return $this->_render($template->getPath(), $data);
	}
	
	/**
	 * 
	 * @param string $viewPath path to view file
	 * @param array $data data to use in php language. Example: $value
	 * @param array $values variables from template. Example: ${value}
	 * @throws FileNotFoundException if file not found
	 * @return string view output
	 */
	public function view(string $viewPath, array $data) {
		if (!file_exists($viewPath)) {
			throw new FileNotFoundException($viewPath);	
		}
		return $this->_render($viewPath, $data);
	}
	
	public function translate(string $content) {		
		preg_match_all('/\${(.*?)}/', $content, $match);
		foreach ($match[1] as $m){
			$content = str_replace('${' . $m . '}', $this->_getValue($m), $content);
		}		
		return $content;
	}

	private function _render(string $view, array $data) {
		extract($data);
		ob_start();
		require $view;
		$buffer = ob_get_contents();
		ob_get_clean();
		return $buffer;
	}
	
	private function _getValue($key) {
		if (strpos($key, self::SEPARATOR)) {
			$array = explode(self::SEPARATOR, $key);
			return $this->_i18n->get(trim($array[0]), explode(",", $array[1]));
		}				
		return $this->_i18n->get(trim($key));
	}
}

