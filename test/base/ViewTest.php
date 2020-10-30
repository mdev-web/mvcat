<?php

namespace bomi\mvcat\test\base;

use PHPUnit\Framework\TestCase;
use bomi\mvcat\base\View;

class ViewTest extends TestCase {

	private const DATA = array("value" => "my value");
	private const TPL_VARS = array("\${variable}" => "my template variable");
	
	private View $_view;
	
	public function setUp(): void {
		$this->_view = new View();
	}
	
	/**
	 * @test
	 */
	public function viewTest() {
		$result = $this->_view->view("resources/views/viewtest.inc", self::DATA, self::TPL_VARS );
		$this->assertEquals("hallo my value my template variable", $result);
	}
	
	/**
	 * 
	 * @expectedException FileNotFoundException
	 */
	public function viewNotFoundTest() {
		$this->_view->view("resources/views/notexistingfile.inc", self::DATA, self::TPL_VARS );
	}
}

