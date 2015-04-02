<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/useradmin.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/binder.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
			redirect_to("login.php");
			exit;
		
		}
		
?>
<?php   
	
	$entryid = $_GET['entryid'];
	$_SESSION['studentid'] = $studentid;
	
	
	$sql  =  "SELECT tblgrade.entryid, tblgrade.studentid, lastname, firstname, middlename, pix, tblsubject.subjectcode, ";
	$sql .=  "tblsubject.subjectdesc, unit, credit, grade, semester, acadyear ";
	$sql .=	 "FROM tblstudent INNER JOIN ( tblgrade INNER JOIN tblsubject ";
	$sql .=	 "ON tblgrade.subjectcode = tblsubject.subjectcode ) ";
	$sql .=	 "ON tblstudent.studentid = tblgrade.studentid ";
	$sql .=	 "WHERE tblgrade.entryid = " . $entryid . " LIMIT 1 ";
			 
	$theGrade = Grade::find_by_sql($sql);
	
?>
<html>
	<head>
		<title> ON - LINE GRADE VIEWER </title>
		
	<link rel="stylesheet" type="text/css" href="main.css"/>
	</head>
<body id="home">

	<div id="outerbox">

			<div id="branding2">
			
				<div id="navigation">
					
					<ol id="menu">
					
						<li><a href="admin.php"> Home </a></li>
						<li><a href="#"> Profile </a></li>
						<li><a href="#"> Account </a></li>
						<li style="background:none;"><a href="logout.php"> Logout </a></li>
					
					<ol>
				
				</div>
				
				<h3 id="logo"> OGV </h3>
				
				<ol id="year">
				
					<li class="firstyear"><a href="admin.php?yearlevel=<?php echo urlencode('First Year'); ?>">> 1st Year </a></li>
					<li class="secondyear"><a href="admin.php?yearlevel=<?php echo urlencode('Second Year'); ?>"> 2nd Year </a></li>
					<li class="thirdyear"><a href="admin.php?yearlevel=<?php echo urlencode('Third Year'); ?>"> 3rd Year </a></li>
					<li class="fourthyear"><a href="admin.php?yearlevel=<?php echo urlencode('Fourth Year'); ?>"> 4th Year </a></li>
					<li class="allyear"><a href="admin.php?yearlevel=<?php echo urlencode('All Year'); ?>"> All Year </a></li>
				
				</ol>
				
				<p class="online"> ON-LINE GRADE VIEWER </p>
			
				<h3 id="track"> Track your grades online </h3>
			
			</div> <!-- branding -->
			
			
			<div id="profile">
			
				<div id="profilecontents">
				
					<h3 id="profileheader" style="background:url(images/admin.png) no-repeat top left;"> ADMIN </h3>
			
					
					<img src="profilepics/
						
							<?php 
							
								if ($theGrade[0]->pix == null || !file_exists("profilepics/" .$theGrade[0]->pix)) {
								
									echo "nophoto.png";
															
								} else {
									
									echo $theGrade[0]->pix;
								
								}
							
							?>
						
						" width="112" height="152" class="profilepic"/>
			
						<p class="profiledetails"><a href='printout.php' style="font-size:.9em;"> PRINT GRADES </a></p>
								
				</div>
				<div id="profilefooter"> </div>
						
			</div>
			
		
			<div id="grades">
		
				<div id="gradescontent">
				
					<h3 id="gradeheader"> </h3>
					<p> &nbsp; </p>
					<h3 style="margin-left:18px;"><?php echo $theGrade[0]->lastname . ", " . $theGrade[0]->firstname . " " . $theGrade[0]->middlename; ?></h3>
					
					<?php foreach ($theGrade as $grade) { ?>
					
					<form action="executeupdate.php?entryid=<?php echo $grade->entryid;?>&studentid=<?php echo $grade->studentid; ?>" method="post" style="display:none;">
					
					<table class="details">
												
							<?php 
							
								echo "<tr>";
									
									echo "<td class='code' style='width:83px;'> CODE </td> ";
									echo "<td class='code' style='width:105px;'> DESCRIPTION </td> ";
									echo "<td class='unit' style='width:110px;'> SEMESTER </td> ";
									echo "<td class='rating'> ACAD YEAR </td> ";
									echo "<td class='rating'> UNITS </td> ";
									echo "<td class='rating'> RATING </td> ";
	
								echo "</tr>";
															
							?>
						
							<tr>
								<td class="leftalign"><?php echo $grade->subjectcode; ?></td>
								<td class="leftalign"><?php echo $grade->subjectdesc; ?></td>
								<td>
								
									<select id="semester" name="semester" style="font-size:0.95em;">
										<?php $fetchedarray = array('','1st Semester','2nd Semester','Summer');?>
										<?php echo $binder->selectCurrentNonDB2($fetchedarray, $grade->semester); ?>
									</select>
								
								</td>
								<td>
								
									<select id="acadyear" name="acadyear" style="font-size:0.95em;">
									
										<?php 
											$array1 = array('','2005 to 2006','2006 to 2007','2007 to 2008','2008 to 2009','2009 to 2010','2010 to 2011');
											$array2 = array('2011 to 2012','2012 to 2013','2013 to 2014','2014 to 2015');
										?>
										
										<?php $fetchedarray = array_merge($array1,$array2);?>
										<?php echo $binder->selectCurrentNonDB2($fetchedarray, $grade->acadyear); ?>
										
									</select>
								
								</td>
								<td>
								<?php 
								
									if ($grade->credit == 0) {
								
										echo "(" . $grade->unit . ")"; 
										
									} else {
									
										echo $grade->unit; 
										
									}
														
								?></td>
								<td>
								<select name="grade" id="grade" style="font-size:1em;">
													
									<?php echo $binder->selectCurrentNonDB($grade->grade); ?>
								
								</select>
								</td>
								<td class="update"><input type="submit" name="submit" id="submit" value="SAVE" style="font-size:1em;"/></td>
							</tr>
							
						
							
					</table>
			
					</form>	
					
					<?php  } ?>
					
				</div>
			
			</div>
			
	</div>
	
</body>
</html>