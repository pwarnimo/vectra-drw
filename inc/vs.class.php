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
	
	public function createDrawing($drawing) {
		try {
			$qry = "INSERT INTO tblDrawing (idDrawing) VALUES (:drawing)";
			
			$stmt = $this->dbh->prepare($qry);
			$stmt->bindValue(":drawing", $drawing, PDO::PARAM_STR);
			
			if ($stmt->execute()) {
				$xml = new DOMDocument("1.0");
		
				$root = $xml->createElement("ok");
			
				$xml->appendChild($root);
			
				return $xml->saveXML();
			}
			else {
				$xml = new DOMDocument("1.0");
		
				$root = $xml->createElement("message");
			
				$cmd = $xml->createAttribute("cmd");
				$cmd->value = "error";
				
				$drawing = $xml->createAttribute("drawing");
				$drawing->value = "";
				
				$user = $xml->createAttribute("user");
				$user->value = "";
			
				$root->appendChild($cmd);
				$root->appendChild($user);
				$root->appendChild($drawing);
			
				$xml->appendChild($root);
			
				return $xml->saveXML();
			}
		}
		catch(PDOException $e) {
			echo "<pre>PDO has encountered an error: " + $e->getMessage() + "</pre>";
			die();
		}
	}
	
	public function createUser($username) {
		try {
			$qry = "INSERT INTO tblUser (idUser) VALUES (:username)";
			
			$stmt = $this->dbh->prepare($qry);
			$stmt->bindValue(":username", $username, PDO::PARAM_STR);
			
			if ($stmt->execute()) {
				$xml = new DOMDocument("1.0");
		
				$root = $xml->createElement("ok");
			
				$xml->appendChild($root);
			
				return $xml->saveXML();
			}
			else {
				$xml = new DOMDocument("1.0");
		
				$root = $xml->createElement("message");
			
				$cmd = $xml->createAttribute("cmd");
				$cmd->value = "error";
				
				$drawing = $xml->createAttribute("drawing");
				$drawing->value = "";
				
				$user = $xml->createAttribute("user");
				$user->value = "";
			
				$root->appendChild($cmd);
				$root->appendChild($user);
				$root->appendChild($drawing);
			
				$xml->appendChild($root);
			
				return $xml->saveXML();
			}
		}
		catch(PDOException $e) {
			echo "<pre>PDO has encountered an error: " + $e->getMessage() + "</pre>";
			die();
		}
	}
	
	public function addShape($x, $y, $width, $height, $color, $type, $filled, $drawing, $username) {
		try {
			$timestamp = date("Y\-m\-d H\:i\:s");
		
			$qry = "INSERT INTO tblElement (dtX, dtY, dtWidth, dtHeight, dtColor, dtType, dtFilled, dtLastUpdate, fiDrawing) VALUES (:x, :y, :width, :height, :color, :type, :filled, :timestamp, :drawing)";
		
			$stmt = $this->dbh->prepare($qry);
			$stmt->bindValue(":x", (int)$x, PDO::PARAM_INT);
			$stmt->bindValue(":y", (int)$y, PDO::PARAM_INT);
			$stmt->bindValue(":width", (int)$width, PDO::PARAM_INT);
			$stmt->bindValue(":height", (int)$height, PDO::PARAM_INT);
			$stmt->bindValue(":color", $color, PDO::PARAM_STR);
			$stmt->bindValue(":type", (int)$type, PDO::PARAM_INT);
			$stmt->bindValue(":filled", $filled, PDO::PARAM_BOOL);
			$stmt->bindValue(":timestamp", $timestamp, PDO::PARAM_STR);
			$stmt->bindValue(":drawing", $drawing, PDO::PARAM_STR);
			
			if ($stmt->execute()) {
				if ($this->updateUserTimestamp($username, $timestamp)) {
					$xml = new DOMDocument("1.0");
		
					$root = $xml->createElement("ok");
				
					$xml->appendChild($root);
				
					return $xml->saveXML();
				}
				else {
					$xml = new DOMDocument("1.0");
		
					$root = $xml->createElement("message");
				
					$cmd = $xml->createAttribute("cmd");
					$cmd->value = "error";
					
					$drawing = $xml->createAttribute("drawing");
					$drawing->value = "";
					
					$user = $xml->createAttribute("user");
					$user->value = "";
				
					$root->appendChild($cmd);
					$root->appendChild($user);
					$root->appendChild($drawing);
				
					$xml->appendChild($root);
				
					return $xml->saveXML();
				}
			}
			else {
				$xml = new DOMDocument("1.0");
		
				$root = $xml->createElement("message");
			
				$cmd = $xml->createAttribute("cmd");
				$cmd->value = "error";
				
				$drawing = $xml->createAttribute("drawing");
				$drawing->value = "";
				
				$user = $xml->createAttribute("user");
				$user->value = "";
			
				$root->appendChild($cmd);
				$root->appendChild($user);
				$root->appendChild($drawing);
			
				$xml->appendChild($root);
			
				return $xml->saveXML();
			}
		}
		catch(PDOException $e) {
			echo "<pre>PDO has encountered an error: " + $e->getMessage() + "</pre>";
			die();
		}
	}
	
	public function updateUserTimestamp($username, $timestamp) {
		try {
			$qry = "UPDATE tblUser SET dtLastUpdate = :timestamp WHERE idUser = :username";
			
			$stmt = $this->dbh->prepare($qry);
			$stmt->bindValue(":timestamp", $timestamp, PDO::PARAM_STR);
			$stmt->bindValue(":username", $username, PDO::PARAM_STR);
			
			if ($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		catch(PDOException $e) {
			echo "<pre>PDO has encountered an error: " + $e->getMessage() + "</pre>";
			die();
		}
	}
	
	public function loadShapesFromDrawing($drw) {
		$xml = new DOMDocument("1.0");
		
		$root = $xml->createElement("message");
		
		$cmd = $xml->createAttribute("cmd");
		$cmd->value = "load";
		
		$drawing = $xml->createAttribute("drawing");
		$drawing->value = "";
		
		$user = $xml->createAttribute("user");
		$user->value = "";
		
		$root->appendChild($cmd);
		$root->appendChild($user);
		$root->appendChild($drawing);
	
		try {
			$qry = "SELECT * FROM tblElement WHERE fiDrawing = :drawing";
			
			$stmt = $this->dbh->prepare($qry);
			$stmt->bindValue(":drawing", "CassieHicks", PDO::PARAM_STR);
			
			$stmt->execute();
			
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($result as $row) {
				$element = $xml->createElement("element");
				
				$eId = $xml->createAttribute("id");
				$eId->value = $row["idElement"];
				
				$eX = $xml->createAttribute("x");
				$eX->value = $row["dtX"];
				
				$eY = $xml->createAttribute("y");
				$eY->value = $row["dtY"];
				
				$eWidth = $xml->createAttribute("width");
				$eWidth->value = $row["dtWidth"];
				
				$eHeight = $xml->createAttribute("height");
				$eHeight->value = $row["dtHeight"];
				
				$eColor = $xml->createAttribute("color");
				$eColor->value = $row["dtColor"];
				
				$eType = $xml->createAttribute("type");
				$eType->value = $row["dtType"];
				
				$eFilled = $xml->createAttribute("filled");
				$eFilled->value = $row["dtFilled"];
				
				$eCmd = $xml->createAttribute("cmd");
				$eCmd->value = "1";
				
				$element->appendChild($eId);
				$element->appendChild($eX);
				$element->appendChild($eY);
				$element->appendChild($eWidth);
				$element->appendChild($eHeight);
				$element->appendChild($eColor);
				$element->appendChild($eType);
				$element->appendChild($eFilled);
				$element->appendChild($eCmd);
				
				$root->appendChild($element);
			}
			
			$xml->appendChild($root);
			
			return $xml->saveXML();
		}
		catch(PDOException $e) {
			echo "<pre>PDO has encountered an error: " + $e->getMessage() + "</pre>";
			die();
		}
	}
	
	public function loadDiff($username, $drw) {
		$xml = new DOMDocument("1.0");
		
		$root = $xml->createElement("message");
		
		$cmd = $xml->createAttribute("cmd");
		$cmd->value = "diff";
		
		$drawing = $xml->createAttribute("drawing");
		$drawing->value = "";
		
		$user = $xml->createAttribute("user");
		$user->value = "";
		
		$root->appendChild($cmd);
		$root->appendChild($user);
		$root->appendChild($drawing);
	
		try {
			$qry = "SELECT dtLastUpdate FROM tblUser WHERE idUser = :username";
			
			$stmt = $this->dbh->prepare($qry);
			$stmt->bindValue(":username", $username, PDO::PARAM_STR);
			$stmt->execute();
			
			$lastUpd = $stmt->fetch(PDO::FETCH_NUM);
			
			$qry = "SELECT * FROM tblElement WHERE fiDrawing = :drawing AND dtLastUpdate > :timestamp";
			
			$stmt = $this->dbh->prepare($qry);
			$stmt->bindValue(":drawing", $drw, PDO::PARAM_STR);
			$stmt->bindValue(":timestamp", $lastUpd[0], PDO::PARAM_STR);
			$stmt->execute();
		
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($result as $row) {
				$element = $xml->createElement("element");
				
				$eId = $xml->createAttribute("id");
				$eId->value = $row["idElement"];
				
				$eX = $xml->createAttribute("x");
				$eX->value = $row["dtX"];
				
				$eY = $xml->createAttribute("y");
				$eY->value = $row["dtY"];
				
				$eWidth = $xml->createAttribute("width");
				$eWidth->value = $row["dtWidth"];
				
				$eHeight = $xml->createAttribute("height");
				$eHeight->value = $row["dtHeight"];
				
				$eColor = $xml->createAttribute("color");
				$eColor->value = $row["dtColor"];
				
				$eType = $xml->createAttribute("type");
				$eType->value = $row["dtType"];
				
				$eFilled = $xml->createAttribute("filled");
				$eFilled->value = $row["dtFilled"];
				
				$eCmd = $xml->createAttribute("cmd");
				$eCmd->value = "1";
				
				$element->appendChild($eId);
				$element->appendChild($eX);
				$element->appendChild($eY);
				$element->appendChild($eWidth);
				$element->appendChild($eHeight);
				$element->appendChild($eColor);
				$element->appendChild($eType);
				$element->appendChild($eFilled);
				$element->appendChild($eCmd);
				
				$root->appendChild($element);
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
		return "<pre><img style=\"float:left; margin-right:5px;\" src=\"img/vectra-logo.png\">VECTRA SERVER 0.9<br>" . date("Y\-m\-d H\:i\:s") . "<br>Copyright &copy;2014 Warnimont Pol</pre>";
	}
}