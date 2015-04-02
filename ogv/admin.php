<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/useradmin.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/gwa.php");?>
<?php include_once("functions/function.php"); ?>
<?php include_once("classes/Zebra_Pagination.php"); ?>
<?php  
 	
	if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
	
		redirect_to("adminlogin.php");
		exit;
	
	}
		
?>
<?php 

	$yearlevel = $_GET['yearlevel'];
	
	$pagination = new Zebra_Pagination();
	
	$records_per_page = 50;
	
	if (!isset($yearlevel)) {
	
		$yearlevel = "First Year";
		
		$sql  = "SELECT * FROM tblstudent WHERE year = '$yearlevel' ORDER BY lastname, firstname, middlename ";
		$sql .= " LIMIT " . ($pagination->get_page() - 1) * $records_per_page;
		$sql .= ", " . $records_per_page;
			
	} else {
	
		$yearlevel = $yearlevel;
		
		$sql  = "SELECT * FROM tblstudent WHERE year = '$yearlevel' ORDER BY lastname, firstname, middlename ";
		$sql .= " LIMIT " . ($pagination->get_page() - 1) * $records_per_page;
		$sql .= ", " . $records_per_page;
	
	}
	
	if ($yearlevel == "All Year") {
	
		$sql  = "SELECT * FROM tblstudent ORDER BY lastname, firstname, middlename ";
		$sql .= " LIMIT " . ($pagination->get_page() - 1) * $records_per_page;
		$sql .= ", " . $records_per_page;
	
	} 
		

	$pagination->records_per_page($records_per_page);
	$theGrade = Grade::find_by_sql($sql);
	$rows = Grade::count_search_results($yearlevel);
								
	$pagination->records($rows);
	
?>
<?php require_once('includes/header_admin.php'); ?>

			<p id="gwaonhover"></p>	
			
			<div id="profile">
			
				<div id="profilecontents">
				
					<h3 id="profileheader" style="background:url(images/admin.png) no-repeat top left;"> ADMIN </h3>
			
					
					<ol class="menu">
					
						<li><a href="adduser.php"> ADD USER </a></li>
						<li><a a target='_blank' href='downloads/CPT-Curriculum.pdf'> COURSE CURRICULUM </a></li>
								
					</ol>
								
				</div>
				<div id="profilefooter"> </div>
				
		
			</div>
			
		
			<div id="grades">
		
				<div id="gradescontent">
				
					<h3 id="gradeheader"> </h3>
					
					<h3 style="margin-left:18px;"><?php echo $yearlevel ?></h3>
					
					<table class="details">
								
								
							<?php echo createlabelstudent2(); ?>
							<?php foreach ($theGrade as $grade) { ?>
						
								<tr>
									<td class="leftalign"><a target='_blank' href="printout_evaluation_admin.php?studentid=<?php echo $grade->studentid; ?>"><?php echo strtoupper($grade->lastname) . ", " . $grade->firstname . " " . $grade->middlename; ?></a></td>
									<td class="leftalign"><?php echo $grade->username . " (" . $grade->passkey . ")"; ?></td>
									<td class="viewgrade"><a href="viewgrade.php?studentid=<?php echo $grade->studentid; ?>"><img src="images/view copy.png"></a></td>
									<td><a href="deletestudent.php?studentid=<?php echo $grade->studentid; ?>&yearlevel=<?php echo $yearlevel; ?>" onclick="return confirm('Are you sure you want to delete this student?');"><img src="images/delete.png"></a></td>
								</tr>
					
							<?php } ?>
					</table>
					
							
								
				</div>
				
				<?php
			
						$pagination->render();
				
					?>		
			
			</div>
			
	</div>
	<div class="overlay_search"><ol></ol></div>


	
</body>
</html>