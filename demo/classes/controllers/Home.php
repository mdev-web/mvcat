<?php
namespace demo\classes\controllers;

use bomi\mvcat\base\Controller;

class Home extends Controller  {

	public function __construct() {
		parent::__construct();
	}
	
	public function indexAction(array $params) {
		echo $this->view("index.inc", $params, "main");
	}
}

