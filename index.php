<?php
//include "inc/vs.class.php";

include(dirname(__FILE__) . "/inc/vs.class.php");

$vcs = new VectraServer();

$p = xml_parser_create();

xml_parse_into_struct($p, file_get_contents('php://input'), $vals, $index);
xml_parser_free($p);

$cmd = $vals[0]["attributes"]["CMD"];

/*if ($cmd === "drawings") {
	Header("Content-type: text/xml");
	echo $vcs->getAvailableDrawings();
}
else if ($cmd === "create") {
	$vcs->createDrawing($vals[0]["attributes"]["DRAWING"]);
}*/

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
	
		break;
}

//echo file_get_contents('php://input');

//var_dump($_POST);

//$dataPOST = trim(file_get_contents('php://input'));
/*$xmlData = simplexml_load_string(file_get_contents('php://input'));

$xml = simplexml_load_string($xmlData->asXML());

echo $xml->message->attributes()->cmd;*/

//echo $xmlData->message->attributes()->cmd;

//$vcs->debug();

/*if (isset($_POST["xml"])) {
	$dataPOST = trim(file_get_contents('php://input'));
	$xmlData = simplexml_load_string($dataPOST);

	echo $xmlData;
	
	/*switch ($_GET["action"]) {
		case "drawings" :
			Header("Content-type: text/xml");
			echo $vcs->getAvailableDrawings();
			
			break;
			
		case "createDrawing" :
			Header("Content-type: text/xml");
			echo $vcs->createDrawing("testing1337");
		
			break;
			
		case "createUser" :
			Header("Content-type: text/xml");
			echo $vcs->createUser("pwarnimo");
			
			break;
			
		default :
			echo $vcs->version();
			
			break;
	}*/
/*}
else {
	echo $vcs->version();
}*/