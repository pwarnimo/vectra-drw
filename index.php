<?php
//include "inc/vs.class.php";

include(dirname(__FILE__) . "/inc/vs.class.php");

$vcs = new VectraServer();

$p = xml_parser_create();

if (file_get_contents('php://input') == NULL) {
	echo $vcs->version();
}
else {
	xml_parse_into_struct($p, file_get_contents('php://input'), $vals, $index);
	xml_parser_free($p);

	$cmd = $vals[0]["attributes"]["CMD"];

	switch ($cmd) {
		case "drawings" :
			Header("Content-type: text/xml");
			echo $vcs->getAvailableDrawings();
		
			break;
			
		case "create" :
			Header("Content-type: text/xml");
			echo $vcs->createDrawing($vals[0]["attributes"]["DRAWING"]);
		
			break;
			
		case "update" :
			$shape = $vals[1]["attributes"];
		
			Header("Content-type: text/xml");
			echo $vcs->addShape($shape["X"], $shape["Y"], $shape["WIDTH"], $shape["HEIGHT"], $shape["COLOR"], $shape["TYPE"], $shape["FILLED"], $vals[0]["attributes"]["DRAWING"], $vals[0]["attributes"]["USER"]);
		
			break;
			
		case "load" :
			$drawing = $vals[0]["attributes"]["DRAWING"];
		
			Header("Content-type: text/xml");
			echo $vcs->loadShapesFromDrawing($drawing);
		
			break;
			
		case "diff" :
			$drawing = $vals[0]["attributes"]["DRAWING"];
			$user = $vals[0]["attributes"]["USER"];
		
			Header("Content-type: text/xml");
			echo $vcs->loadDiff($vals[0]["attributes"]["USER"], $drawing);
			
			//echo $vcs->loadDiff("pwarnimo", "CassieHicks");
		
			break;
	}
}