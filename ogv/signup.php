<?php require_once("classes/session.php"); ?>
<?php require_once("classes/mysql.php"); ?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/user.php"); ?>
<?php require_once("functions/function.php");?>
<?php
	
	$user = new User();
	$grade = new Grade();
	
	$user->lastname = $_POST['lastname'];
	$user->firstname = $_POST['firstname'];
	$user->middlename = $_POST['middlename'];
	$user->courseid = (int)1;
	$user->year = $_POST['yearlevel'];
	$user->username = $_POST['username'];
	$user->passkey = $_POST['password'];
	
	$user->attributes('db_fields_student');
	$user->createuser('db_fields_student');
	
	$studentid = $user->laststudentid();
	
	$grade->setgradesheet($studentid);
	
	redirect_to("notice.php");

?>