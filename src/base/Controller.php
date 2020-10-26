<?php

namespace bomi\mvcat\base;

use bomi\mvcat\core\data\context\RequestContext;
use bomi\mvcat\exceptions\MvcException;

abstract class Controller {
	private static RequestContext $_requestContext;
	private static array $_templates;
	
	private static string $_viewPath;
	private static View $_view;

	protected function __construct() { 
		static::$_view = new View();
	}
	
	protected function view(string $view, array $data = array(), string $template = null): string {
		if ($template !== null && key_exists($template, static::$_templates)) {
			return static::$_view->template(self::$_viewPath . $view, $data, static::$_templates[$template]);
		} else if ($template !== null && !key_exists($template, static::$_templates)) {
			throw new MvcException("Template '$template' not defined in MvcFactory using method template(youtemplate)");
		}
		return static::$_view->view(self::$_viewPath . $view, $data);
	}
	
	protected function getRequest() : RequestContext {
		return static::$_requestContext;
	}
	
	protected function extendTemplate(string $templateName, string $key, string $value) {
		if (key_exists($templateName, static::$_templates)) {
			static::$_templates[$templateName][$key] = $value;
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
}