<?php

namespace bomi\mvcat\manifest\entities;

use Tebru\Gson\Annotation\SerializedName;

class Data {
	
	/**
	 * @var DataConnection
	 * @SerializedName("connection")
	 */
	private $_connection;
	public function getConnection(): DataConnection {
		if ($this->_connection == null) {
			return new DataConnection();
		}
		return $this->_connection;
	}
	
	/**
	 * @var array
	 * @SerializedName("repositories")
	 */
	private $_repositories;
	public function getRepositories(): array {
		return $this->_repositories;
	}
	
	public function __construct() {
		$this->_connection = new DataConnection();
		$this->_repositories = array();
	}
}

