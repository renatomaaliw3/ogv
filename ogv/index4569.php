<?php include_once("includes/header.php");?>
<script type="text/javascript" src="scripts/formcheckNoCross.js"></script>
		
			<div id="preamble">
				
				<h3> SIGN UP FOR A FREE GRADE VIEWER ACCOUNT   </h3> <br/>
				<p> Your <span style="color:blue;font-weight:bold;"> On-Line Grade Viewer Account (OGV) </span> lets you create a 
				new account  to manage, view and track your progress towards
				finishing  your course of BSIT - Computer Technology. 
				</p>
				<br/>
				<p>
					Already have an OGV account? <a href="login.php" style="color:blue;font-weight:bold;"> Sign in. </a>
				</p>
				<br/>
			
			</div>
			
			<div id="signup">
				
				<h3> Sign Up </h3>	
				<p> Sign Up Image </p>
				
				
				<form action="signup.php" method="post" id="signupform">
						
					<div>
					
						<label for="lastname"> Last Name </label>
						<input type="text" name="lastname" id="lastname" class="textfield"/>
				
					</div>
					
					<div>
					
						<label for="firstname"> First Name </label>
						<input type="text" name="firstname" id="firstname" class="textfield"/>
				
					</div>
					
					<div>
					
						<label for="middlename"> Middle Name </label>
						<input type="text" name="middlename" id="middlename" class="textfield"/>
				
					</div>
					
					<div>
					
						<label for="yearlevel"> Year Level </label>
						<select name="yearlevel" id="yearlevel" class="textfield" style="padding-top:4px;">
						
							<option value="First Year"> First Year </option>
							<option value="Second Year"> Second Year </option>
							<option value="Third Year"> Third Year </option>
							<option value="Fourth Year"> Fourth Year </option>
						
						</select>
				
					</div>
					
					<div>
					
						<label for="username"> User Name </label>
						<input type="text" name="username" id="username" class="textfield"/>
				
					</div>
					
					<div>
					
						<label for="password"> Password </label>
						<input type="password" name="password" id="password" class="textfield"/>
				
					</div>
					
					<div>
					
						<label for="confirmpassword"> Confirm Password </label>
						<input type="password" name="confirmpassword" id="confirmpassword" class="textfield"/>
				
					</div>
					
					<div>
					
						<label for="submit"> &nbsp; </label>
						<input type="submit" value="SIGN UP" name="submit" id="submit" class="signupbutton"/>
				
					</div>
					
				<p id="message" style="color:red;font-weight:bold;"></p>
				
				</form>
				
						
			</div> <!-- #signup -->
			
			<div id="footersignup">
				
				
			</div>

	</div> <!-- wrapper -->
	
</body>


</html>