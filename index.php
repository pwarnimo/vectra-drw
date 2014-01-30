<?php
include "inc/vs.class.php";

$vcs = new VectraServer();

//$vcs->debug();

if (isset($_GET["action"])) {
	switch ($_GET["action"]) {
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
	}
}
else {
	echo $vcs->version();
}