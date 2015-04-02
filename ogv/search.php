<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/useradmin.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/gwa.php");?>
<?php require_once("classes/binder.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
			redirect_to("index.php");
			exit;
			
		}

		$search_string = trim(mysql_real_escape_string($_POST['student_search']));

		$sql  =  "SELECT * FROM tblstudent WHERE CONCAT(lastname, ' ', firstname, ' ', middlename) LIKE '%$search_string%' ";
		$sql .= "ORDER BY lastname, firstname, middlename";

		$theResult = Grade::find_by_sql($sql);
		$num_rows = Grade::count_search($sql);


		if ($num_rows === 0) {

			$output = "<li style='color: red;'> No matching records found </li>";

		} else {

	
			foreach ($theResult as $result) {

				$output .= "<li><a href='viewgrade.php?studentid=" . $result->studentid . "'>" . htmlentities($result->lastname) . ", " . htmlentities($result->firstname) . " " . htmlentities($result->middlename) . "</a></li>";

			}

		}

		echo $output;
		
?>