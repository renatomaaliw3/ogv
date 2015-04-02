<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/useradmin.php");?>
<?php require_once("classes/grade.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
			redirect_to("login.php");
			exit;
		
		}
		
		
		$studentid = $_GET['studentid'];
		
		$grade = new Grade();
		
		$grade->studentid = $studentid;
		$grade->subjectcode = $_POST['subjectcode'];
		$grade->semester = $_POST['semester'];
		$grade->acadyear = $_POST['acadyear'];
		$grade->grade = $_POST['grade'];
		
		$grade->attributes('db_fields_retake');
		$grade->addretake('db_fields_retake');
		
		
		redirect_to("viewgrade.php?studentid=$studentid");
		
?>