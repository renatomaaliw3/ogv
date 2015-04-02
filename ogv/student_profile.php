<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/binder.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
			redirect_to("index.php");
			exit;
		
		}
		
?>
<?php   

	$studentid = $_GET['studentid'];
	
	$sql  =  "SELECT lastname, firstname, middlename, year, pix, username, passkey FROM tblstudent ";
	$sql .=	 "WHERE studentid = " . $studentid . "  LIMIT 1 ";
			 
	$theGrade = Grade::find_by_sql($sql);
	
?>
<?php require_once('includes/header_admin.php'); ?>
			
			
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
			
					<form action="executeprofileupdate.php?studentid=<?php echo $studentid; ?>" method="post" class="profile">
				
						<div>
							<label for="lastname"> Last Name </label>
							<input type="text" id="lastname" name="lastname" class="textfield" value="<?php echo $grade->lastname; ?>" required/>
						</div>	
						<div>
							<label for="lastname"> First Name </label>
							<input type="text" id="firstname" name="firstname" class="textfield" value="<?php echo $grade->firstname; ?>" required/>
						</div>	
						<div>
							<label for="lastname"> MiddleName </label>
							<input type="text" id="middlename" name="middlename" class="textfield" value="<?php echo $grade->middlename; ?>"/>
						</div>	
						<div>
							<label for="lastname"> Year Level </label>
							<select id="yearlevel" name="yearlevel" required>
								
								<?php 
								
									$fetchedarray = array('First Year','Second Year','Third Year','Fourth Year'); 
									$match = $grade->year;
								?>
								<?php echo $binder->selectCurrentNonDB2($fetchedarray, $match); ?>
							
							</select>
						</div>
						<div>
							<label for="username"> Username </label>
							<input type="text" id="username" name="username" class="textfield" value="<?php echo $grade->username; ?>" required/>
						</div>
						<div>
							<label for="passkey"> Password </label>
							<input type="text" id="passkey" name="passkey" class="textfield" value="<?php echo $grade->passkey; ?>" required/>
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