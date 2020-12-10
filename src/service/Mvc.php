<?php
namespace bomi\mvcat\service;

use bomi\mvcat\base\Controller;
use bomi\mvcat\exceptions\MvcException;
use bomi\mvcat\context\MvcContext;
use bomi\mvcat\i18n\I18NService;
use bomi\mvcat\manifest\entities\I18N;

class Mvc {
	protected $_controller;
	protected $_action;
	protected $_parameters = array ();
	protected $_viewsDestination;
	protected $_requestContext;
	protected $_templates = array ();
	protected $_repositories = array ();	
	/** @var I18N  */
	protected $_i18n;
	/** @var I18NService  */
	protected $_i18NService;
	
	protected $_globals = array();

	protected function __construct() {}

	private function setContext(MvcContext $context) {
		$this->_controller = $context->getManifestContext()->getController();
		$this->_action = strtolower($context->getManifestContext()->getAction()) . "Action";
		$this->_parameters = $context->getManifestContext()->getParameters();
		$this->_viewsDestination = $context->getManifestContext()->getViewsDestination();
		$this->_requestContext = $context->getManifestContext()->getRequestContext();
		$this->_templates = $context->getManifestContext()->getTemplates();
		$this->_repositories = $context->getManifestContext()->getRepositories();
		$this->_i18n = $context->getManifestContext()->getI18N();
		$this->_globals = $context->getManifestContext()->getGlobals();
		$this->_i18NService = new I18NService($this->_i18n->getDefault(), $this->_globals);
	}

	public static function create(MvcContext $context): self {
		$mvc = new self();
		$mvc->setContext($context);
		return $mvc;
	}
	
	public function setLanguage($lang = null) {
		if ($lang !== null && !empty($this->_i18n->getLanguages()) && array_key_exists($lang, $this->_i18n->getLanguages())) {
			$this->_i18NService = new I18NService($this->_i18n->getLanguages()[$lang], $this->_globals);
		} 
	}

	public function execute(): void {
		if ($this->isSupportedClass($this->_controller)) {
			$controller = new $this->_controller();

			$this->addViewDestination($controller, $this->_viewsDestination);
			$this->addRequestContext($controller, $this->_requestContext);
			$this->addTemplates($controller, $this->_templates);
			$this->_addMethod($controller, "setRepositories", $this->_repositories);
			$this->_addMethod($controller, "setI18N", $this->_i18NService);

			if (method_exists($controller, $this->_action) && $controller->beforeAction($this->_parameters)) {
				$controller->{$this->_action}($this->_parameters);
				$controller->afterAction();
			} else {
				throw new MvcException("Method {$this->_action} not found in controller {$this->_controller}", 404);
			}
		}
	}

	protected function isSupportedClass($class) {
		return $this->_isClassExists($this->_controller) && $this->_isClassFromBaseController($this->_controller);
	}

	protected function addTemplates($controller, $value) {
		$this->_addMethod($controller, "setTemplates", $value);
	}

	protected function addViewDestination($controller, $value) {
		$this->_addProperty($controller, "_viewPath", $value);
	}

	protected function addRequestContext($controller, $value) {
		$this->_addMethod($controller, "setRequestContext", $value);
	}

	private function _addMethod($controller, $name, $value) {
		$reflectionClass = new \ReflectionClass($controller);
		$reflectionParentClass = $reflectionClass->getParentClass();
		$method = $reflectionParentClass->getMethod($name);
		$method->setAccessible(true);
		$method->invokeArgs($controller, [ 
				$value
		]);
	}

	private function _addProperty($controller, $name, $value) {
		$reflectionClass = new \ReflectionClass($controller);
		$reflectionParentClass = $reflectionClass->getParentClass();
		$reflectionProperty = $reflectionParentClass->getProperty($name);
		$reflectionProperty->setAccessible(true);
		$reflectionProperty->setValue($value);
	}

	private function _isClassExists($class) {
		if (class_exists($class)) {
			return true;
		}
		throw new MvcException("Controller $class not exists", 404);
	}

	private function _isClassFromBaseController($class) {
		if (is_subclass_of($class, Controller::class)) {
			return true;
		}
		throw new MvcException("Controller $class not inheriting parent class " . Controller::class);
	}
}
