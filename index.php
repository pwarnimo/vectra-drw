<?php
include "inc/vs.class.php";

$vcs = new VectraServer();

//$vcs->debug();
Header("Content-type: text/xml");
echo $vcs->getAvailableDrawings();

//echo "<pre><img style=\"float:left; margin-right:5px;\" src=\"img/vectra-logo.png\">VECTRA SERVER 0.1<br>" . date("Y\-m\-d H\:i\:s") . "<br>Copyright &copy;2014 Warnimont Pol</pre>";