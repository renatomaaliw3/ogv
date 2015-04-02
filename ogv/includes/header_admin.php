 <html>
	<head>
		<title> ON - LINE GRADE VIEWER </title>
		
	<link rel="stylesheet" type="text/css" href="main.css"/>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/jquery_functions.js"></script>
	</head>
<body id="home">

	<div id="outerbox">

			<div id="branding2">
			
				<div id="navigation">
					
					<ol id="menu">
					
						<li><a href="admin.php"> Home </a></li>
						<li><a href="#"> Profile </a></li>
						<li><a href="adminupdate.php"> Account </a></li>
						<li style="background:none;"><a href="logout.php"> Logout </a></li>
					
					</ol>
				
				</div>
				
				<h3 id="logo"> OGV </h3>
				
				<ol id="year">
				
					<li class="firstyear"><a href="admin.php?yearlevel=<?php echo urlencode('First Year'); ?>"> <!-- 1st Year --> </a></li>
					<li class="secondyear"><a href="admin.php?yearlevel=<?php echo urlencode('Second Year'); ?>"> <!-- 2nd Year --> </a></li>
					<li class="thirdyear"><a href="admin.php?yearlevel=<?php echo urlencode('Third Year'); ?>"> <!-- 3rd Year --> </a></li>
					<li class="fourthyear"><a href="admin.php?yearlevel=<?php echo urlencode('Fourth Year'); ?>"> <!-- 4th Year --> </a></li>
					<li class="allyear"><a href="admin.php?yearlevel=<?php echo urlencode('All Year'); ?>"> <!-- All Year --> </a></li>
				
				</ol>
				
				<p class="online" style="text-align: left; padding-left: 42px; padding-top: 3px; width: 80%;"> ON-LINE GRADE VIEWER </p>
			
				<input type="text" name="student_search" id="student_search" placeholder="Quick Search [Lastname OR Firstname]" maxlength="25"> <!-- SEARCH -->
				
			</div> <!-- branding -->