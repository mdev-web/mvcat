<?php

namespace bomi\mvcat\base;

use bomi\mvcat\manifest\entities\Template;
use bomi\mvcat\exceptions\FileNotFoundException;

class View {
	public const VIEW_RENDER = "viewRender";

	public function __construct() {}
	
	public function template(string $view, array $data = array(), Template $template = null) {
		$template->addVariable(self::VIEW_RENDER, $this->view($view, $data, $template->getVariables()));
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
		return $this->_render($viewPath, $data, $values);
	}

	private function _render(string $view, array $data, array $values) {
		extract($data);
		ob_start();
		require_once $view;
		$buffer = ob_get_contents();
		ob_end_clean();
		return strtr($buffer, $values);
	}
}

