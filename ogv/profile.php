<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/binder.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$session->is_logged_in()) { //if the user is not logged in
		
			redirect_to("index.php");
			exit;
		
		}
		
?>
<?php   

	$redirect = $_GET['redirect'];
	
	$sql  =  "SELECT lastname, firstname, middlename, year, pix FROM tblstudent ";
	$sql .=	 "WHERE tblstudent.studentid = " . $_SESSION['studentid'] . "  LIMIT 1 ";
			 
	$theGrade = Grade::find_by_sql($sql);
	
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
				
					<p class="profiledetails"><a href="uploadphoto.php"> UPLOAD PHOTO </a></p>
							
				</div>
				<div id="profilefooter"> </div>
				
		
			</div>
			
		
			<div id="grades">
		
				<div id="gradescontent">
				
					<h3 id="gradeheader"> </h3>
					
					<h3 style="margin-left:18px;"> UPDATE PROFILE </h3>
			
			<?php foreach($theGrade as $grade) { ?>
			
					<form action="execute_profileupdate.php?redirect=<?php echo $redirect; ?>" method="post" class="profile">
				
						<div>
							<label for="lastname"> Last Name </label>
							<input type="text" id="lastname" name="lastname" class="textfield" value="<?php echo $grade->lastname; ?>" required/>
						</div>	
						<div>
							<label for="lastname"> First Name </label>
							<input type="text" id="firstname" name="firstname" class="textfield" value="<?php echo $grade->firstname; ?>" required/>
						</div>	
						<div>
							<label for="lastname"> Middle Initial </label>
							<input type="text" id="middlename" name="middlename" class="textfield" value="<?php echo $grade->middlename; ?>" maxlength="3" required/>
						</div>	
						<div style="display: none;">
							<label for="lastname"> Year Level </label>
							<select id="yearlevel" name="yearlevel">
								
								<?php 
								
									$fetchedarray = array('First Year','Second Year','Third Year','Fourth Year'); 
									$match = $grade->year;
								?>
								<?php echo $binder->selectCurrentNonDB2($fetchedarray, $match); ?>
							
							</select>
						</div>	
						<div>
							<label for="update"> &nbsp; </label>
							<input type="submit" id="submit" name="submit" value="UPDATE"/>
						</div>	
						
			<?php } ?>		
							
					</form>
					<ol id="errormessages"></ol>
										
				</div>
			
			</div>
			
	</div>
	
</body>
</html>