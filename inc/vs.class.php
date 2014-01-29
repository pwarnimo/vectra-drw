<?php

include_once("config.inc.php");

class VectraServer {
	private $dbh;
	
	public function __construct() {
		$dsn = dbtype . ":dbname=" . database . ";host=" . hostname;
            
            
		try {
			$this->dbh = new PDO($dsn, username, password);
		}
		catch(PDOException $e) {
			echo "PDO has encountered an error: " + $e->getMessage();
			die();
		}
	}
	
	public function debug() {
		echo "<pre>VECTRA SERVER OK</pre>"
	}
}