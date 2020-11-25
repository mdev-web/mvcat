<?php

namespace bomi\mvcat\test\base;

use PHPUnit\Framework\TestCase;
use bomi\mvcat\base\View;
use bomi\mvcat\manifest\entities\Template;
use bomi\mvcat\exceptions\FileNotFoundException;

class ViewTest extends TestCase {

	private const DATA = array("value" => "my value");
	public  const TPL_VARS = array("\${variable}" => "my template variable");
	
	private $_view;
	
	public function setUp(): void {
		$this->_view = new View();
	}
	
	/**
	 * @test
	 */
	public function viewTest() {
		$result = $this->_view->view("resources/files/viewtest.inc", self::DATA, self::TPL_VARS);
		$this->assertEquals("Ich bin value 'my value'. Ich bin template variable 'my template variable'", $result);
	}
	
	/**
	 * @test
	 */
	public function viewWithoutTemplateVariableTest() {
		$result = $this->_view->view("resources/files/viewtest.inc", self::DATA);
		$this->assertEquals("Ich bin value 'my value'. Ich bin template variable '\${variable}'", $result);
	}
	
	/**
	 * 
	 * @test
	 */
	public function viewNotFoundTest() {
		try {
			$this->_view->view("resources/files/notexistingfile.inc", self::DATA, self::TPL_VARS );
		} catch (FileNotFoundException $e) {
			$this->assertNotNull($e->getMessage());
		}
	}
	
	/**
	 * @test
	 */
	public function templateTest() {
		$template = new Template();
		$template->__set("path", "resources/files/templatetest.tpl");
		$template->__set("variables", array("variable" => "my template variable"));
		
		$result = $this->_view->template("resources/files/viewtest.inc", self::DATA, $template);
		$this->assertEquals("This is a template with view: < Ich bin value 'my value'. Ich bin template variable 'my template variable' >", $result);
	}
	
	/**
	 * @test
	 */
	public function templateWithoutTemplateTest() {
		$result = $this->_view->template("resources/files/viewtest.inc", self::DATA);
		$this->assertEquals("Ich bin value 'my value'. Ich bin template variable '\${variable}'", $result);
	}
}
