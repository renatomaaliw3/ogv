<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	

		if (!$session->is_logged_in()) { //if the user is not logged in
		
			redirect_to("index.php");
			exit;
		
		}
		
	
		$user = new User();
		
		$user->studentid = $_SESSION['studentid'];
		$user->lastname = $_POST['lastname'];
		$user->firstname = $_POST['firstname'];
		$user->middlename = $_POST['middlename'];
		$user->year = $_POST['yearlevel'];
		$user->username = $_POST['username'];
		$user->passkey = $_POST['passkey'];
			
		$user->attributes('db_fields_user');
		$user->updateuser('db_fields_user');
		
		redirect_to("home.php");
	
		
?>