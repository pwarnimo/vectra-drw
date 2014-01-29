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
	
	public function getAvailableDrawings() {
		$xml = new DOMDocument("1.0");
		
		$root = $xml->createElement("message");
		
		$cmd = $xml->createAttribute("cmd");
		$cmd->value = "drawings";
		
		$drawing = $xml->createAttribute("drawing");
		$drawing->value = "";
		
		$user = $xml->createAttribute("user");
		$user->value = "";
		
		$root->appendChild($cmd);
		$root->appendChild($user);
		$root->appendChild($drawing);
	
		try {
			$qry = "SELECT * FROM tblDrawing";
			
			$stmt = $this->dbh->prepare($qry);
			$stmt->execute();
			
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($res as $row) {
				$drawing = $xml->createElement("drawing");
				$did = $xml->createAttribute("id");
				$did->value = $row["idDrawing"];
				
				$drawing->appendChild($did);
				$root->appendChild($drawing);
			}
			
			$xml->appendChild($root);
			
			return $xml->saveXML();
		}
		catch(PDOException $e) {
			echo "<pre>PDO has encountered an error: " + $e->getMessage() + "</pre>";
			die();
		}
	}
	
	public function debug() {
		echo "<pre>VECTRA SERVER OK</pre>";
	}
	
	public function version() {
		return "<pre><img style=\"float:left; margin-right:5px;\" src=\"img/vectra-logo.png\">VECTRA SERVER 0.1<br>" . date("Y\-m\-d H\:i\:s") . "<br>Copyright &copy;2014 Warnimont Pol</pre>";
	}
}