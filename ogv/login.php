<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php include_once("functions/function.php"); ?>
<?php
		
					
		if (isset($_POST['submit'])) {
			
			$username = $_POST['username'];
			$passkey = $_POST['password'];
				
			$found_user = User::authenticate($username, $passkey); // $found_user is an Object
			
			if ($found_user) {
				
				$session->login($found_user);
				redirect_to("home.php");
				
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
				
				<h3> LOGIN TO YOUR GRADE VIEWER ACCOUNT   </h3> <br/>
				<p> Your <span style="color:blue;font-weight:bold;"> On-Line Grade Viewer Account (OGV) </span> lets you 
				manage, view <br/> and track your progress towards
				finishing your course. 
				</p>
				<br/>
				Pilot Testing for BSIT - Computer Technology (1st Year and 2nd Year)
				<p>
					<!-- No OGV account yet? <a href="index.php" style="color:blue;font-weight:bold;"> Sign up. </a> -->
				</p>
				<br/>
				
				<p style="color:red;font-weight:bold;text-align:center;padding-right:35px;"><?php echo $message; ?></p>
				
				<br/>
					
			</div>
			
			<div id="signup">
				
				<h3> Sign Up </h3>	
				<p class="login"> LOGIN Image </p>
				
				<form action="login.php" method="post" id="signupform">
						
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

	</div> <!-- wrapper -->
	
</body>


</html>