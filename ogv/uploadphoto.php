<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/binder.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$session->is_logged_in()) { //if the user is not logged in
		
			redirect_to("login.php");
			exit;
		
		}
		
?>
<?php   

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
					
					<h3 style="margin-left:18px;"> UPLOAD PHOTO for <?php echo $theGrade[0]->firstname . " " . $theGrade[0]->lastname; ?></h3>
			
					<form enctype="multipart/form-data" action="executeuploadphoto.php?studentid=<?php echo $_SESSION['studentid']; ?>" method="post" class="profile">
						
						<input type="hidden" name="MAX_FILE_SIZE" value="1073741824" />
						
						<div>
						
							<label for="uploadfile">  </label>
							
								<input type="file" name="file_upload" id="file_upload" size="38" accept="image/jpeg"/>
																	
						</div>
					
							<input type="submit" value="UPLOAD PHOTO" style="width:150px;" /> 
					
									
					</form>
										
				</div>
			
			</div>
			
	</div>
	
</body>
</html>