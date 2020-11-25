<?php

namespace bomi\mvcat\demo\classes\models;

use JsonSerializable;

class User implements JsonSerializable {

	private $_id;
	private $_firstname;
	private $_lastname;
	private $_isActiv;
	
	public function getId() {
		return $this->_id;
	}

	public function getFirstname() {
		return $this->_firstname;
	}

	public function getLastname() {
		return $this->_lastname;
	}

	public function isActive() {
		return $this->_isActiv;
	}

	public function __construct(int $id, string $f, string $l, bool $a) {
		$this->_id = $id;
		$this->_firstname = $f;
		$this->_lastname = $l;
		$this->_isActiv = $a;
	}
	
	public function jsonSerialize() {
		$a = array();
		foreach ($this->getPrivateProperties($this) as $prop) {
			$a[$prop->getName()] = $this->{$prop->getName()};
		}
		return $a;
	}
	
	private function getPrivateProperties($obj) {
		$reflect = new \ReflectionClass($obj);
		return $reflect->getProperties(\ReflectionProperty::IS_PRIVATE);
	}
}

