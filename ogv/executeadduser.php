<?php require_once("classes/sessionadmin.php"); ?>
<?php require_once("classes/mysql.php"); ?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/useradmin.php"); ?>
<?php require_once("functions/function.php");?>
<?php
	
	$useradmin = new UserAdmin();

	$useradmin->lastname = $_POST['lastname'];
	$useradmin->firstname = $_POST['firstname'];
	$useradmin->middlename = $_POST['middlename'];
	$useradmin->year = $_POST['yearlevel'];
	$useradmin->username = $_POST['username'];
	$useradmin->passkey = $_POST['password'];
	
	$useradmin->attributes('db_fields_users');
	$useradmin->createuser('db_fields_users');

	redirect_to("admin.php");

?>