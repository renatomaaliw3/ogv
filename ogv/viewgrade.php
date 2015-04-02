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
			
		//}
	
?>
<?php require_once('includes/header_admin.php'); ?>
			
			
			<div id="profile">

			<?php  

				$studentid = $_GET['studentid'];

				$sql  =  "SELECT * FROM tblstudent ";
				$sql .=	 "WHERE studentid = " . $studentid . " LIMIT 1 ";
			 
				$theGrade = Grade::find_by_sql($sql);

			?>
			
				<div id="profilecontents">
				
					<h3 id="profileheader" style="background:url(images/admin.png) no-repeat top left;"> ADMIN </h3>
			
			
						<img src="profilepics/
						
							<?php 
							
								if ($theGrade[0]->pix == null || !file_exists("profilepics/" . $theGrade[0]->pix)) {
								
									echo "nophoto.png";
															
								} else {
									
									echo $theGrade[0]->pix;
								
								}
							
							?>
						
						" width="112" height="152" class="profilepic"/>
			
						<p class="profiledetails"><a target='_blank' href='printoutgrade.php?studentid=<?php echo $studentid; ?>' style="font-size:.9em;"> RATING HISTORY </a></p>
						<p class="profiledetails"><a target='_blank' href='printout_evaluation_admin.php?studentid=<?php echo $studentid; ?>' style="font-size:.9em;"> RATING EVALUATION </a></p>
						<p class="profiledetails"><a target='_blank' href='statsprintout.php?studentid=<?php echo $studentid ?>' style="font-size:.9em;"> RATING STATISTICS </a></p>
								
				</div>
				<div id="profilefooter"> </div>
						
			</div>
			
		
	<div id="grades">

		<?php

			$sqlpix = "SELECT studentid, lastname, firstname, middlename, pix, year FROM tblstudent WHERE studentid = " . $studentid;
			
			$thePix = Grade::find_by_sql($sqlpix);
			
			$sqlf  =  "SELECT tblgrade.entryid, lastname, firstname, middlename, credit, year, pix, offered, tblstudent.studentid, tblsubject.subjectcode, ";
			$sqlf .=  "tblsubject.subjectdesc, unit, grade, semester, acadyear ";
			$sqlf .=  "FROM tblstudent INNER JOIN ( tblgrade INNER JOIN tblsubject ";
			$sqlf .=  "ON tblgrade.subjectcode = tblsubject.subjectcode ) ";
			$sqlf .=  "ON tblstudent.studentid = tblgrade.studentid ";
			$sqlf .=  "WHERE tblstudent.studentid = " . $studentid . " AND (grade = '' OR grade = '0.00' OR grade = '5.00' OR grade = 'DRP') "; 
			$sqlf .=  " ORDER BY acadyear, semester, entryid ";
			
			$NoGrade = Grade::find_by_sql($sqlf);

			$gwa = new GwA();

		?>

		<div id="gradescontent">
				
					<h3 id="gradeheader"> </h3>
					<p style="width:100%;text-align:right;"><a href="student_profile.php?studentid=<?php echo $studentid;?>" style="padding-right:10px;font-size:0.8em;"> edit profile </a></p>
					<h3 style="margin-left:18px;padding-bottom: 10px;"><?php echo htmlentities($thePix[0]->lastname) . ", " . $thePix[0]->firstname . " " . $thePix[0]->middlename . " (" . "<span id='copy_gwa'></span>" . ")";?></h3>
		
					<?php $count_subject_passed = Grade::count_passed_subjects($_GET['studentid']); ?>
					<?php $count_subject_conditional = Grade::count_conditional_subjects($_GET['studentid']); ?>
					<?php $count_subject_dropped = Grade::count_dropped_subjects($_GET['studentid']); ?>
					<?php $count_subject_failed = Grade::count_failed_subjects($_GET['studentid']); ?>

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
				
					<table class="details">
				
					<?php
					
						$sql  = "SELECT DISTINCT studentid, acadyear, semester FROM tblgrade ";
						$sql .= " WHERE studentid = " . $studentid . " AND acadyear != '' ";
						$sql .= " ORDER BY acadyear ";
						
						$theAcadYear = Grade::find_by_sql($sql);
					
					?>	
						
						<?php foreach ($theAcadYear as $year) { ?>
						
							<tr>
								<td colspan='4' style="font-weight:bold;font-size:1.1em;"><span clas="semester"><?php echo $year->semester; ?></span>  - A.Y.  <span class="acadyear"><?php echo $year->acadyear; ?></span></td>
							</tr>
						
							<tr>	
								<td class='code' style='width:83px;'> CODE </td> 
								<td class='code' style='width:305px;'> DESCRIPTION </td>
								<td class='rating'> UNITS </td>
								<td class='rating'> RATING </td>
							</tr>
					
						<?php
					
						$sql2  = 	"SELECT DISTINCT tblgrade.entryid, lastname, firstname, middlename, credit, year, pix, offered, tblstudent.studentid, tblsubject.subjectcode, ";
						$sql2 .=  	"tblsubject.subjectdesc, unit, grade, semester, acadyear ";
						$sql2 .=	"FROM tblstudent INNER JOIN ( tblgrade INNER JOIN tblsubject ";
						$sql2 .=	"ON tblgrade.subjectcode = tblsubject.subjectcode ) ";
						$sql2 .=	"ON tblstudent.studentid = tblgrade.studentid ";
						$sql2 .=	"WHERE tblstudent.studentid = " . $studentid . " AND acadyear = " . "'" . $year->acadyear . "'" . " AND semester = " . "'" . $year->semester . "'";
						$sql2 .=    " AND (grade = '1.00' OR grade = '1.25' OR grade = '1.50' OR grade = '1.75' OR grade = '2.00' OR grade = '2.25' OR grade = '2.50' OR grade = '2.75' OR grade = '3.00' OR grade = '4.00' OR grade = '5.00' OR grade = 'DRP') ";
						$sql2 .=  	" ORDER BY acadyear, entryid, semester  ";
		
						$theGrade = Grade::find_by_sql($sql2);
							
						?>
											
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
								<td class="entryid" style="display:none;"><?php echo $grade->entryid; ?>
								<td class="studentid" style="display:none;"><?php echo $studentid; ?>
								<td class="update"><a href="updategrade.php?entryid=<?php echo $grade->entryid; ?>" class="e"><img src="images/pencil.png" alt="update"></a></td>
							</tr>
							
							
							<?php } ?>	
						<?php } ?>	
					</table>
					

			<?php if ($count_subject_passed >= 56) { ?>
			
					<p style="text-align:center;margin-top:-2px;margin-bottom:15px;font-weight:bold;"> All subjects have been passed </p>
					<p> &nbsp </p>
					 						
				<?php } else { ?>
				
					<hr style="width:450px;"/>
					<a id="marker"></a>
					<table class="details">
					<caption style="font-size:1.2em;font-weight:bold;padding-bottom:5px;"> NOT YET TAKEN/DEFICIENT SUBJECTS </caption>
						<?php
					echo "<tr>";
									
						echo "<td class='code' style='width:83px;'> CODE </td> ";
						echo "<td class='code' style='width:305px;'> DESCRIPTION </td> ";
						echo "<td class='unit' style='width:110px;'> SEMESTER </td> ";
						echo "<td class='rating'> ACAD YEAR </td> ";
						echo "<td class='rating'> UNITS </td> ";
						echo "<td class='rating'> RATING </td> ";
	
					echo "</tr>";
					?>	
						<?php foreach ($NoGrade as $grade) { ?>
						
							
							<?php 
							
								//static $x = 0;
															
									// $x represents the count of subjects by year and if 1st sem of second sem
									
									//if ($x == 0 || $x == 9 || $x == 18 || $x == 26 || $x == 34 || $x == 41 || $x == 48 || $x == 54) {
																					
										
												
									//}
									
									if ($x >= 0 && x <= 100) { //get the gwa from CPT101 to OJT2
									
										$gwa->gwarating($grade->grade,$grade->credit);
										
									}
									
								
								
								//++$x;
							?>
						
							<tr>
								<td class="leftalign"><?php echo $grade->subjectcode; ?></td>
								<td class="leftalign"><?php echo $grade->subjectdesc; ?></td>
								<td class="leftalign"><?php //echo $grade->semester; ?></td>
								<td class="leftalign"><?php //echo $grade->acadyear; ?></td>
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
								<td class="entryid" style="display:none;"><?php echo $grade->entryid; ?>
								<td class="studentid" style="display:none;"><?php echo $studentid; ?>
								<td class="update"><a href="updategrade.php?entryid=<?php echo $grade->entryid; ?>" class="e"><img src="images/pencil.png" alt="update"></a></td>
							</tr>
							
						<?php  } ?>
					
					
					</table>
				
					<p style="margin-left:18px;font-size:0.95em;font-weight:bold;"> FOR RETAKE SUBJECTS </p>

					<form action="addfailed.php?studentid=<?php echo $studentid;?>" method="post">
						
						<table class="details">
												
							<?php 
							
								echo "<tr>";
									
									echo "<td class='code' style='width:83px;'> CODE </td> ";
									echo "<td class='code' style='width:105px;'> SEMESTER </td> ";
									echo "<td class='unit' style='width:110px;'> ACADEMIC YEAR </td> ";
									echo "<td class='rating'> RATING </td> ";
	
								echo "</tr>";
															
							?>
						
							<tr>
								<td class="leftalign">
								<select id="subjectcode" name="subjectcode" style="font-size:0.95em;">
									<?php echo $binder->populate_comboboxskip('tblgrade','subjectcode','subjectcode','subjectcode', $studentid); ?>
								</td>
								<td class="centeralign">
									<select id="semester" name="semester" style="font-size:0.95em;">
										<?php $fetchedarray = array('1st Semester','2nd Semester','Summer');?>
										<?php echo $binder->selectCurrentNonDB2($fetchedarray, '1st Semester') ?>
									</select>
								</td>
						
								<td class="centeralign">
									<select id="acadyear" name="acadyear" style="font-size:0.95em;">
									
										<?php 
											$array1 = array('','2005 to 2006','2006 to 2007','2007 to 2008','2008 to 2009','2009 to 2010','2010 to 2011');
											$array2 = array('2011 to 2012','2012 to 2013','2013 to 2014','2014 to 2015');
										?>
										
										<?php $fetchedarray = array_merge($array1,$array2);?>
										<?php echo $binder->selectCurrentNonDB2($fetchedarray, '2012-2013'); ?>
										
									</select>
								</td>
								
								<td>
								<select name="grade" id="grade" style="font-size:1em;">
									
									<?php $fetchedarray = array('','1.00','1.25','1.50','1.75','2.00','2.25','2.50','2.75','3.00','4.00','5.00','DRP');?>
									<?php echo $binder->selectCurrentNonDB2($fetchedarray,'0.00'); ?>
								
								</select>
								</td>
								<td class="update"><input type="submit" name="submit" id="submit" value="ADD" style="font-size:1em;"/></td>
							</tr>
							
						
							
					</table>
				
					</form>	
							
				<?php } ?>
				
					<table class="details" style="margin-top:-10px;">
					
						<tr style="background:#FED;font-weight:bold;font-size:1.1em;">
							
							<td class="leftalign" style="width:158px;"> Overall GWA </td>
							<td style="width:58px;" id="gwa"><?php echo number_format($gwa->thegwa,3); ?></td>
							
						</tr>
						
					</table>
		
				</div> <!-- gradescontent -->

		</div> <!-- grades -->

</div> <!-- wrapper -->
	
	<div class="overlay"></div>
	<div class="overlay_search"><ol></ol></div>
	

</body>
</html>