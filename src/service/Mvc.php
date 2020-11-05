<?php
namespace bomi\mvcat\service;

use bomi\mvcat\base\Controller;
use bomi\mvcat\exceptions\MvcException;
use bomi\mvcat\context\MvcContext;
use bomi\mvcat\context\RequestContext;

class Mvc {
	protected string $_controller;
	protected string $_action;
	protected array $_parameters = array ();
	protected string $_viewsDestination;
	protected RequestContext $_requestContext;
	protected array $_templates = array ();
	protected array $_repositories = array ();

	protected function __construct() {}

	private function setContext(MvcContext $context) {
		$this->_controller = $context->getManifestContext()->getController();
		$this->_action = strtolower($context->getManifestContext()->getAction()) . "Action";
		$this->_parameters = $context->getManifestContext()->getParameters();
		$this->_viewsDestination = $context->getManifestContext()->getViewsDestination();
		$this->_requestContext = $context->getManifestContext()->getRequestContext();
		$this->_templates = $context->getManifestContext()->getTemplates();
		$this->_repositories = $context->getManifestContext()->getRepositories();
	}

	public static function create(MvcContext $context): self {
		$mvc = new self();
		$mvc->setContext($context);
		return $mvc;
	}

	public function execute($language): void {
		if ($this->isSupportedClass($this->_controller)) {
			$controller = new $this->_controller();

			$this->addViewDestination($controller, $this->_viewsDestination);
			$this->addRequestContext($controller, $this->_requestContext);
			$this->addTemplates($controller, $this->_templates);
			$this->_addMethod($controller, "setRepositories", $this->_repositories);

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
