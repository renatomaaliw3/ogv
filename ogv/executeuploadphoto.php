<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/photo.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$session->is_logged_in()) { //if the user is not logged in
		
			redirect_to("login.php");
			exit;
		
		}
		
		$photo = new Photo();
		
		$photo->studentid = $_SESSION['studentid'];
		
		$photo->attach_file($_FILES['file_upload']);
		
		
		if ($photo->savephoto()) {
		
			$_SESSION['message'] = "Photo uploaded successfully!";
		
		} else {
		
			$_SESSION['message'] = join("<br/>", $photo->errors);
		
		}
			
		redirect_to("home.php?studentid=" . $photo->studentid);
			
?>