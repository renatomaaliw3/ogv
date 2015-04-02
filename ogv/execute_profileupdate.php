<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 		
		if (!$session->is_logged_in()) { //if the user is not logged in
		
			redirect_to("login.php");
			exit;
		
		}
		
		$studentid = $_SESSION['studentid'];
				
		$grade = new Grade();
		
		$grade->studentid = $studentid;
		$grade->lastname = $_POST['lastname'];
		$grade->firstname = $_POST['firstname'];
		$grade->middlename = $_POST['middlename'];
		$grade->year = $_POST['yearlevel'];
		
		$grade->attributes('db_fields_student');
		$grade->updateprofile('db_fields_student');
		
		redirect_to("home.php");
	
?>