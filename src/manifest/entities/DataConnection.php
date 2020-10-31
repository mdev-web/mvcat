<?php

namespace bomi\mvcat\manifest\entities;

use Tebru\Gson\Annotation\SerializedName;

class DataConnection {

	/**
	 *
	 * @var string
	 * @SerializedName("host")
	 */
	private $_host;

	public function getHost() {
		return $this->_host;
	}

	/**
	 *
	 * @var string
	 * @SerializedName("dbname")
	 */
	private $_dbname;

	public function getDbname() {
		return $this->_dbname;
	}

	/**
	 *
	 * @var string
	 * @SerializedName("username")
	 */
	private $_username;

	public function getUsername() {
		return $this->_username;
	}

	/**
	 *
	 * @var string
	 * @SerializedName("password")
	 */
	private $_password;

	public function getPassword() {
		return $this->_password;
	}

	/**
	 *
	 * @var array
	 * @SerializedName("additional")
	 */
	private $_additional;

	public function getAdditional() {
		return $this->_additional;
	}

	public function __construct() {}
}

