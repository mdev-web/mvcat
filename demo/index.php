<?php 
session_start();
use bomi\mvcat\base\Template;
use bomi\mvcat\MvcBuilder;
require_once '../libs/vendor/autoload.php';

MvcBuilder::build() 
	->template("main", setMainTemlate())
	->configure("routes.json")
	->execute(function(int $code, Exception $exception = null){
		if ($code !== 200) {
			echo $exception->getMessage();
		}
	});

function setMainTemlate() : Template {
	$template = new Template("public/templates/main.phtml");
	$template->setValues(
		array(
			"title" => "Demo",
			"header" => "Main header")
		);
	$template->addValue("baseUrl", "/mvcat/demo/");
	return $template;
}
