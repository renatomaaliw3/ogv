<?php //require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/useradmin.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/gwa.php");?>
<?php require_once("classes/binder.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		//if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
			//redirect_to("index.php");
			//exit;
		
		//}
		
		
		$entryid = $_POST['entryid'];
		$studentid = $_POST['studentid'];
		
		$grade = new Grade();
		
		$grade->entryid = $entryid;
	
		$grade->grade = $_POST['grade'];
		
		if ($grade->grade == '' || $_POST['semester'] == '' || $_POST['acadyear'] == '') {
		
			$grade->semester = '';
			$grade->acadyear = '';
			$grade->grade = '';
			
		
		} else {
		
			$grade->semester = $_POST['semester'];
			$grade->acadyear = $_POST['acadyear'];
			
		}
			
		
		$grade->attributes('db_fields_grades');
		$grade->updategrade('db_fields_grades');

		echo $studentid;
		
?>