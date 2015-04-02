<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/gwa.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$session->is_logged_in()) { //if the user is not logged in
		
			redirect_to("index.php");
			exit;
		
		}
		
?>
<?php   
	
	$yearoffered = $_GET['year'];
	$yearlevel = $_GET['yearlevel'];
	
	if (!isset($yearoffered)) {
		
		$yearoffered = "";
	
	}
	
	if (!isset($yearlevel)) {
	
		$yearlevel = "Summary of Rating";
	
	}
	
	
	$sql  =  "SELECT * FROM tblstudent ";
	$sql .=	 "WHERE studentid = " . $_SESSION['studentid'] . " LIMIT 1 ";
			 
	$theGrade = Grade::find_by_sql($sql);
	
	$gwa = new GWA();
?>

<?php require_once('includes/header_student.php'); ?> <!-- includes -->

		<div id="profile">
			
				<div id="profilecontents">
				
					<h3 id="profileheader"> PROFILE </h3>
										
						<img src="profilepics/
						
							<?php 
							
								if ($theGrade[0]->pix == null || !file_exists("profilepics/" .$theGrade[0]->pix)) {
								
									echo "nophoto.png";
															
								} else {
									
									echo $theGrade[0]->pix;
								
								}
							
							?>
						
						" width="112" height="152" class="profilepic"/>
					
			
					<p class="profiledetails"> <?php echo $theGrade[0]->username; ?></p>
					<p class="profiledetails"> <?php echo $theGrade[0]->year; ?></p>
					
					
	
				</div>
				<div id="profilefooter"> </div>
				
		
			</div>
			
		
			<div id="grades">
		
				<div id="gradescontent">
				
					<h3 id="gradeheader"> </h3>
					
					<h3 style="margin-left:18px; padding-bottom: 10px;"><?php echo $yearlevel ?></h3> 

					<?php $count_subject_passed = Grade::count_passed_subjects($_SESSION['studentid']); ?>
					<?php $count_subject_conditional = Grade::count_conditional_subjects($_SESSION['studentid']); ?>
					<?php $count_subject_dropped = Grade::count_dropped_subjects($_SESSION['studentid']); ?>
					<?php $count_subject_failed = Grade::count_failed_subjects($_SESSION['studentid']); ?>

					<div class="summary">
						<p> TOTAL SUBJECTS: </p> <span> 56 </span>
						<p> REMAINING SUBJECTS: </p><span> <?php echo (56 - $count_subject_passed); ?> </span>
						<p style="color: blue;"> SUBJECTS PASSED: </p><span style="color: blue;"> <?php echo $count_subject_passed; ?> </span>
						
					</div>

					<div class="summary">

						<p> CONDITIONAL: </p><span> <?php echo $count_subject_conditional; ?> </span>
						<p> DROPPED: </p><span> <?php echo $count_subject_dropped; ?> </span>
						<p style="color: red;"> FAILED: </p><span style="color: red;"> <?php echo $count_subject_failed; ?> </span>

					</div>





		<?php //if ($yearlevel == "All Year") { ?>
		
					<table class="details">
					
					<?php
					
						$sql  = "SELECT DISTINCT studentid, acadyear, semester FROM tblgrade ";
						$sql .= " WHERE studentid = " . $_SESSION['studentid'] . " AND acadyear != '' ";
						$sql .= " ORDER BY acadyear ";
						
						$theAcadYear = Grade::find_by_sql($sql);
					
					?>	
						
						<?php foreach ($theAcadYear as $year) { ?>
						
							
						<?php
					
						$sql2  = 	"SELECT DISTINCT tblgrade.entryid, lastname, firstname, middlename, credit, year, pix, offered, tblstudent.studentid, tblsubject.subjectcode, ";
						$sql2 .=  	"tblsubject.subjectdesc, unit, grade, semester, acadyear ";
						$sql2 .=	"FROM tblstudent INNER JOIN ( tblgrade INNER JOIN tblsubject ";
						$sql2 .=	"ON tblgrade.subjectcode = tblsubject.subjectcode ) ";
						$sql2 .=	"ON tblstudent.studentid = tblgrade.studentid ";
						$sql2 .=	"WHERE tblstudent.studentid = " . $_SESSION['studentid'] . " AND acadyear = " . "'" . $year->acadyear . "'" . " AND semester = " . "'" . $year->semester . "' AND offered LIKE '%$yearoffered%' " ;
						$sql2 .=    " AND (grade = '1.00' OR grade = '1.25' OR grade = '1.50' OR grade = '1.75' OR grade = '2.00' OR grade = '2.25' OR grade = '2.50' OR grade = '2.75' OR grade = '3.00' OR grade = '4.00' OR grade = '5.00' OR grade = 'DRP') ";
						$sql2 .=  	" ORDER BY acadyear, semester, entryid ";
		
						$theGrade = Grade::find_by_sql($sql2);
						
						$theCount = Grade::count_subjects($_SESSION['studentid'], $year->acadyear, $year->semester, $yearoffered);
					
							
						?>
				<?php if ($theCount != 0) { ?>
				
							<tr>
								<td colspan='4' style="font-weight:bold;font-size:1.1em;"><?php echo $year->semester . " - A.Y.  " . $year->acadyear ;?></td>
							</tr>
							
							<tr>	
								<td class='code' style='width:83px;'> CODE </td> 
								<td class='code' style='width:305px;'> DESCRIPTION </td>
								<td class='rating'> UNITS </td>
								<td class='rating'> RATING </td>
							</tr>
							
						
											
							<?php foreach ($theGrade as $grade) { ?>
							
							<?php 
								
								$gwa->gwarating($grade->grade,$grade->credit);
								
							?>
							
								<tr>
									<td class="leftalign"><?php echo $grade->subjectcode; ?></td>
									<td class="leftalign"><?php echo $grade->subjectdesc; ?></td>
									<td>
								
								<?php 
								
									if ($grade->credit == 0) {
								
										echo "(" . $grade->unit . ")"; 
										
									} else {
									
										echo $grade->unit; 
										
									}
														
								?></td>
								<td>
								<?php 
								
								
									if ($grade->grade == "5.00" || $grade->grade == "DRP") {
									
										echo "<span style='background:#9d0109;display:block;color:#FFF;'>" . $grade->grade . "</span>";
									
									} else if ($grade->grade == "4.00") {
									
										echo "<span style='background:#f7acb0;display:block;'>" . $grade->grade . "</span>";
									
									} else if ($grade->grade == "0.00") {
									
										echo "";
									
									} else if ($grade->grade == "3.00" || $grade->grade == "2.75") {
									
										echo "<span style='background:#f8fc80;display:block;'>" . $grade->grade . "</span>";
									
									} else {
									
										echo $grade->grade;
									
									}
								
								
								?></td>
								
							</tr>
							
					<?php } ?>		
							<?php } ?>	
						<?php } ?>	
					</table>
		<?php //} ?>		
					<?php if ($yearlevel == "All Year") { ?>
					
						<table class="details" style="margin-top:-10px;">
					
						<tr style="background:#FED;font-weight:bold;font-size:1.1em;">
						
							<td class="leftalign" style="width:158px;"> Overall GWA </td>
							<td style="width:50px;"> <?php echo number_format($gwa->thegwa,3); ?> </td>
						
						</tr>
						
						</table>
					
					<?php } else { ?>
					
						<table class="details" style="margin-top:-10px;">
					
						<tr style="background:#FED;font-weight:bold;font-size:1.1em;">
						
							<td class="leftalign" style="width:158px;"> General Weighted Average (GWA) </td>
							<td style="width:50px;"> <?php echo number_format($gwa->thegwa,3); ?> </td>
						
						</tr>
										
					</table>
					
					
					<?php } ?>
				
				</div>
			
			</div>
			
	</div>
	
</body>
</html>