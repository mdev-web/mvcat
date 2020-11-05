<?php 
session_start();
use bomi\mvcat\service\Mvcat;
require_once '../libs/vendor/autoload.php';

Mvcat::build("manifest.json") 
	->language("de")
	->execute(function(int $code, Exception $exception = null){
		if ($code !== 200) {
			echo $exception->getMessage();
		}
	});
