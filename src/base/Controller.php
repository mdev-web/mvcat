<?php

namespace bomi\mvcat\base;

use bomi\mvcat\exceptions\MvcException;
use bomi\mvcat\context\RequestContext;
use bomi\mvcat\i18n\I18NService;

abstract class Controller {
	private static $_viewPath;
	private static $_repositories;
	
	private $_view;
	private $_templates;
	private $_requestContext;
	
	/** @var I18NService  */
	protected $_i18n;

	public function __construct() { 
		$this->_view = new View();
		$this->_templates = array();
	}
	
	/**
	 * Use method to render view with or without template
	 * 
	 * @param string $view path to your view
	 * @param array $data data in form php variables
	 * @param string $template path to your template. (Optional)
	 * @throws MvcException 
	 * @return string view
	 */
	protected function view(string $view, array $data = array(), string $template = null): string {
		$viewContent = "";
		if ($template !== null && key_exists($template, $this->_templates)) {
			$viewContent = $this->_view->template(self::$_viewPath . $view, $data, $this->_templates[$template]);
		} else if ($template !== null && !key_exists($template, $this->_templates)) {
			throw new MvcException("Template '$template' not defined in MvcFactory using method template(youtemplate)");
		} else {
			$viewContent = $this->_view->view(self::$_viewPath . $view, $data);
		}
		return $this->_view->translate($viewContent);
	}
	
	/**
	 * 
	 * Use method to fetch information about request and post data
	 * @return RequestContext
	 */
	protected function getRequestContext() : RequestContext {
		return $this->_requestContext;
	}
	
	/**
	 * 
	 * @param string $repositoryName configured in manifest
	 * @return mixed your repository
	 */
	protected function getRepository(string $repositoryName) {
		if (key_exists($repositoryName, self::$_repositories)) {
			return self::$_repositories[$repositoryName];
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
	
	protected function setTemplates($templates) {
		$this->_templates = $templates;
	}
	
	protected function setRequestContext($context) {
		$this->_requestContext = $context;
	}
	
	protected function setI18N(I18NService $i18n) {
		$this->_i18n = $i18n;
		$this->_view->setI18N($i18n);
	}
}