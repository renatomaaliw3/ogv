<?php require_once("classes/session.php");?>
<?php require_once("classes/sessionadmin.php");?>
<?php require_once("functions/function.php");?>
<?php

	$session->logout();
	$sessionadmin->logout();
	
	redirect_to("index.php"); 
	
?>