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

	$redirect = $_GET['redirect'];
	
	$sql  =  "SELECT * FROM tbluser ";
	$sql .=	 "WHERE userid = " . $_SESSION['userid'] . "  LIMIT 1 ";
			 
	$theUser = UserAdmin::find_by_sql($sql);
	
?>
<?php require_once('includes/header_admin.php'); ?>
			
			
			<div id="profile">
			
				<div id="profilecontents">
			
					<h3 id="profileheader" style="background:url(images/admin.png) no-repeat top left;"> ADMIN </h3>
			
					
					<ol class="menu">
					
						<li><a href="adduser.php"> ADD USER </a></li>
								
					</ol>
					
				</div>
					
				<div id="profilefooter"> </div>
				
		
			</div>
			
		
			<div id="grades">
		
				<div id="gradescontent">
				
					<h3 id="gradeheader"> </h3>
					
					<h3 style="margin-left:18px;"> CREATE ADMIN USER </h3>
			
			<?php foreach($theUser as $user) { ?>
			
					<form action="executeadduser.php?redirect=<?php echo $redirect; ?>" method="post" class="profile">
				
						<div>
							<label for="lastname"> Last Name </label>
							<input type="text" id="lastname" name="lastname" class="textfield"/>
						</div>	
						<div>
							<label for="firstname"> First Name </label>
							<input type="text" id="firstname" name="firstname" class="textfield"/>
						</div>	
						<div>
							<label for="middlename"> Middle Name </label>
							<input type="text" id="middlename" name="middlename" class="textfield"/>
						</div>
						<div>
							<label for="username"> User Name </label>
							<input type="text" id="username" name="username" class="textfield"/>
						</div>
						<div>
							<label for="password"> Password </label>
							<input type="password" id="password" name="password" class="textfield"/>
						</div>	
						<div>
							<label for="create"> &nbsp; </label>
							<input type="submit" id="submit" name="submit" value="CREATE"/>
						</div>	
						
			<?php } ?>		
							
					</form>
										
				</div>
			
			</div>
			
	</div>
	
</body>
</html>