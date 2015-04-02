<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/useradmin.php");?>
<?php include_once("functions/function.php"); ?>
<?php
		
					
		if (isset($_POST['submit'])) {
			
			$username = $_POST['username'];
			$passkey = $_POST['password'];
				
			$found_user = UserAdmin::authenticate($username, $passkey); // $found_user is an Object
			
			if ($found_user) {
				
				$sessionadmin->login($found_user);
				redirect_to("admin.php");
				
			} else {
				
				$message = "Username/Password combination is incorrect!";
				
			}
			
		
			
		} else {
		
			$username = "";
			$passowrd = "";
	
		}
		 
?>
<?php include_once("includes/header.php");?>
			
			<div id="preamble">
				
				<h3> SYSTEM ADMINISTRATOR LOGIN  </h3> <br/>
				<h3> You are not welcome here if you are not an administrator! </h3>


				<p style="color:red;font-weight:bold;text-align:center;padding-right:35px;"><?php echo $message; ?></p>
				
				<br/>
					
			</div>
			
			<div id="signup">
				
				<h3> Sign Up </h3>	
				<p class="login"> LOGIN Image </p>
				
				<form action="adminlogin.php" method="post" id="signupform">
						
					<div>
					
						<label for="username"> User Name </label>
						<input type="text" name="username" id="username"/>
				
					</div>
					
					<div>
					
						<label for="password"> Password </label>
						<input type="password" name="password" id="password"/>
				
					</div>
							
					<div>
					
						<label for=""> &nbsp; </label>
						<input type="submit" value="LOGIN" name="submit" id="submit" class="signupbutton"/>
				
					</div>
									
				</form>
								
			</div>
			
			<div id="footersignup">
				
				
			</div>
	<a href="index.php" style="padding:2px;font-size:0.7em;"> student login </a>	
	</div> <!-- wrapper -->
	
</body>


</html>