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
		
		
		$user = new UserAdmin();
		
		$user->userid = $_SESSION['userid'];
		$user->lastname = $_POST['lastname'];
		$user->firstname = $_POST['firstname'];
		$user->middlename = $_POST['middlename'];
		$user->username = $_POST['username'];
		$user->passkey = $_POST['password'];
			
		$user->attributes('db_fields_users');
		$user->updateuser('db_fields_users');
		
		redirect_to("admin.php");
	
		
?>