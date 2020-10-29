<?php 
session_start();
use bomi\mvcat\service\MvcBuilder;
require_once '../libs/vendor/autoload.php';

MvcBuilder::build() 
	->configure("manifest.json")
	->execute(function(int $code, Exception $exception = null){
		if ($code !== 200) {
			echo $exception->getMessage();
		}
	});
