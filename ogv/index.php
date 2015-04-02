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
				finishing your course. <br/><br/> Pilot Test for Computer Technology 1st and 2nd Year students
				</p>
				<br/>
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
				
				<form action="index.php" method="post" id="signupform">
						
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

			<p style="font-size: 0.8em;color:blue;height: 1em;margin: 10px 100px;"> Association of Computer Technology Students </p>

			
			<div style="display:none">

			<!-- START OF HIT COUNTER CODE -->
			<br><script language="JavaScript" src="http://www.counter160.com/js.js?img=15"></script><br><a href="http://www.000webhost.com"><img src="http://www.counter160.com/images/15/left.png" alt="free web hosting" border="0" align="texttop"></a><a href="http://www.hosting24.com"><img alt="Hosting24.com web hosting" src="http://www.counter160.com/images/15/right.png" border="0" align="texttop"></a>
			<!-- END OF HIT COUNTER CODE -->

			</div>


	</div> <!-- wrapper -->
	
</body>


</html>