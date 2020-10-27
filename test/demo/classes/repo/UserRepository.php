<?php
namespace bomi\mvcat\test\demo\classes\repo;

use bomi\mvcat\test\demo\classes\models\User;

class UserRepository {
	
	private $_array = [];

	public function __construct() {
		array_push($this->_array, new User(1, "Max", "Mustermann", true));
		array_push($this->_array, new User(2, "John", "Doe", true));	
		array_push($this->_array, new User(3, "Jame", "Nock", false));
		array_push($this->_array, new User(4, "Chuck", "Norric", true));
	}
	
	public function getAll() : array {
		return $this->_array;
	}
	
	public function getActive(bool $a) : array {
		$array = array();
		foreach ($this->_array as $u) {
			if ($u->isActive() === $a) {
				array_push($array, $u);
			}
		}
		return $array;
	}
	
	
	public function get(int $id) : User {
		foreach ($this->_array as $u) {
			if ($u->getId() === $id) {
				return $u;
			}
		}
	}
	
	public function add($f, $l, $a) {
		array_push($this->_array, new User(count($this->_array) + 1, $f, $l, $a));
	}
}

