<?php
namespace ijackwu\ssdb;

/**
 * Class SimpleClient
 * @package SSDB
 */
class SimpleClient extends Client
{
	public function __construct($host, $port, $timeout_ms=2000){
		parent::__construct($host, $port, $timeout_ms);
		$this->easy();
	}
}
