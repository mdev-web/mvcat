<?php

namespace bomi\mvcat\base;

use bomi\mvcat\manifest\entities\Template;

class View {
	public const VIEW_RENDER = "viewRender";

	public function __construct() {}
	
	public function template(string $view, array $data = array(), Template $template = null) {
		$template->addVariable(self::VIEW_RENDER, $this->view($view, $data, $template->getVariables()));
		return $this->_render($template->getPath(), $data, $template->getVariables());
	}
	
	public function view(string $view, array $data, $values = array()) {
		return $this->_render($view, $data, $values);
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

