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
			
		default :
			echo $vcs->version();
			
			break;
	}
}
else {
	echo $vcs->version();
}