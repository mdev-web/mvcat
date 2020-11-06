<?php

namespace bomi\mvcat\base;

use bomi\mvcat\manifest\entities\Template;
use bomi\mvcat\exceptions\FileNotFoundException;
use bomi\mvcat\i18n\I18N;

class View {
	public const VIEW_RENDER = "viewRender";

	private I18N $_i18n;

	public function __construct() {}
	
	public function setLanguageValues(I18N $i18n) {
		$this->_i18n = $i18n;
	}
	
	public function template(string $viewPath, array $data = array(), Template $template = null) {
		if ($template === null) {
			return $this->view($viewPath, $data);
		}
		$template->addVariable(self::VIEW_RENDER, $this->view($viewPath, $data, $template->getVariables()));
		return $this->_render($template->getPath(), $data, $template->getVariables());
	}
	
	/**
	 * 
	 * @param string $viewPath path to view file
	 * @param array $data data to use in php language. Example: $value
	 * @param array $values variables from template. Example: ${value}
	 * @throws FileNotFoundException if file not found
	 * @return string view output
	 */
	public function view(string $viewPath, array $data, array $values = array()) {
		if (!file_exists($viewPath)) {
			throw new FileNotFoundException($viewPath);	
		}
// 		$data["i18n"] = $this->_i18n;
		return $this->_render($viewPath, $data, $values);
	}

	private function _render(string $view, array $data, array $values) {
		extract($data);
		ob_start();
		require $view;
		$buffer = ob_get_contents();
		ob_get_clean();
		return strtr($buffer, $values);
	}
}

