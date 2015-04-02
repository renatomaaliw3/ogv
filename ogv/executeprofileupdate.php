<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/useradmin.php");?>
<?php require_once("classes/grade.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	

		if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
			redirect_to("index.php");
			exit;
		
		}
		
				
		$grade = new Grade();
		
		$grade->studentid = $_GET['studentid'];
		$grade->lastname = $_POST['lastname'];
		$grade->firstname = $_POST['firstname'];
		$grade->middlename = $_POST['middlename'];
		$grade->year = $_POST['yearlevel'];
		$grade->username = $_POST['username'];
		$grade->passkey = $_POST['passkey'];
		
		$grade->attributes('db_fields_student');
		$grade->updateprofile('db_fields_student');
		
		redirect_to("viewgrade.php?studentid=" . $grade->studentid);
		
			
?>