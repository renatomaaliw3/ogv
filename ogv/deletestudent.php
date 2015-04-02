<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/useradmin.php");?>
<?php require_once("classes/grade.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
			redirect_to("login.php");
			exit;
		
		}
		
		$studentid = $_GET['studentid'];
		$yearlevel = $_GET['yearlevel'];
		$user = New User();
			
		$user->deleterecord($studentid);
	
		redirect_to("admin.php?yearlevel=$yearlevel");
		
?>