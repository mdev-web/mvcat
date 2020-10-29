<?php

namespace bomi\mvcat\base;

use bomi\mvcat\exceptions\MvcException;
use bomi\mvcat\context\RequestContext;

abstract class Controller {
	private static string $_viewPath;
	
	private View $_view;
	private array $_templates;
	private RequestContext $_requestContext;	

	public function __construct() { 
		$this->_view = new View();
		$this->_templates = array();
	}
	
	protected function view(string $view, array $data = array(), string $template = null): string {
		if ($template !== null && key_exists($template, $this->_templates)) {
			return $this->_view->template(self::$_viewPath . $view, $data, $this->_templates[$template]);
		} else if ($template !== null && !key_exists($template, $this->_templates)) {
			throw new MvcException("Template '$template' not defined in MvcFactory using method template(youtemplate)");
		}
		return $this->_view->view(self::$_viewPath . $view, $data);
	}
	
	protected function getRequestContext() : RequestContext {
		return $this->_requestContext;
	}
	
	protected function extendTemplate(string $templateName, string $key, string $value) {
		if (key_exists($templateName, $this->_templates)) {
			$this->_templates[$templateName]->addValue($key, $value);
		}
	}
	
	/**
	 * 
	 * @param array $params
	 * @return bool If false, the action is not executed
	 */
	public function beforeAction(array $params): bool { 
		return true;
	}
	
	public function afterAction(): void { }
	
	public abstract function indexAction(array $params);
	
	private function setTemplates($templates) {
		$this->_templates = $templates;
	}
	
	private function setRequestContext($context) {
		$this->_requestContext = $context;
	}
}