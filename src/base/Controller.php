<?php

namespace bomi\mvcat\base;

use bomi\mvcat\exceptions\MvcException;
use bomi\mvcat\context\RequestContext;
use bomi\mvcat\i18n\I18N;

abstract class Controller {
	private static string $_viewPath;
	
	private View $_view;
	private array $_templates;
	private array $_repositories;
	private RequestContext $_requestContext;	

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
		if ($template !== null && key_exists($template, $this->_templates)) {
			return $this->_view->template(self::$_viewPath . $view, $data, $this->_templates[$template]);
		} else if ($template !== null && !key_exists($template, $this->_templates)) {
			throw new MvcException("Template '$template' not defined in MvcFactory using method template(youtemplate)");
		}
		return $this->_view->view(self::$_viewPath . $view, $data);
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
	 * Use this method to extend variables in your template
	 * @param string $templateName
	 * @param string $key
	 * @param string $value
	 */
	protected function extendTemplate(string $templateName, string $key, string $value) {
		if (key_exists($templateName, $this->_templates)) {
			$this->_templates[$templateName]->addVariable($key, $value);
		}
	}
	
	/**
	 * 
	 * @param string $repositoryName configured in manifest
	 * @return mixed your repository
	 */
	protected function getRepository(string $repositoryName) {
		if (key_exists($repositoryName, $this->_repositories)) {
			return $this->_repositories[$repositoryName];
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
	
	protected function setRepositories($repositories) {
		$this->_repositories = $repositories;
	}
	
	protected function setRequestContext($context) {
		$this->_requestContext = $context;
	}
	
	protected function setLanguageValues(I18N $i18n) {
		$this->_view->setLanguageValues($i18n);
	}
}