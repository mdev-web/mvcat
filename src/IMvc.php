<?php
namespace bomi\mvcat;

use bomi\mvcat\base\Template;

interface IMvc {
	function execute() : void;
	
	/**
	 * 
	 * @param Template[] $templates
	 */
	function setTemplates(array $templates) : void;
}

