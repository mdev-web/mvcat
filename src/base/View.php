<?php

namespace bomi\mvcat\base;

class View {
	public const VIEW_RENDER = "viewRender";

	public function __construct() {}
	
	public function template(string $view, array $data = array(), Template $template = null) {
		$template->addValue(self::VIEW_RENDER, $this->view($view, $data, $template->getValues()));
		return $this->_render($template->getFile(), $data, $template->getValues());
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

