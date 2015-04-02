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
					
						<li><a href="home.php"> Home </a></li>
					<!-- 	<li><a href="profile.php"> Profile </a></li> -->
						<li><a href="account.php"> Account </a></li>
						<li style="background:none;"><a href="logout.php"> Logout </a></li>
					
					<ol>
				
				</div>
				
				<h3 id="logo"> OGV </h3>
				
				<ol id="year">
				
					<!-- <li class="firstyear"><a href="home.php?year=1&yearlevel=<?php //echo urlencode('First Year'); ?>"> 1st Year </a></li>
					<li class="secondyear"><a href="home.php?year=2&yearlevel=<?php //echo urlencode('Second Year'); ?>"> 2nd Year </a></li>
					<li class="thirdyear"><a href="home.php?year=3&yearlevel=<?php //echo urlencode('Third Year'); ?>"> 3rd Year </a></li>
					<li class="fourthyear"><a href="home.php?year=4&yearlevel=<?php //echo urlencode('Fourth Year'); ?>"> 4th Year </a></li>-->
					<li class="folder"><a target='_blank' href='printoutgrade_student.php?studentid=<?php echo $_SESSION['studentid']; ?>'> RATING SHEET </a></li>
					<li class="folder"><a target='_blank' href='statsprintout_student.php?studentid=<?php echo $_SESSION['studentid']; ?>'> RATING STATS</a></li>
					<li class="folder"><a target='_blank' href='downloads/CPT-Curriculum.pdf' style="font-size: 0.7em;"> COURSE CURRICULUM </a></li>

				</ol>
				
				<p class="online"> <?php echo $theGrade[0]->firstname . ' ' . $theGrade[0]->middlename . ' ' . $theGrade[0]->lastname; ?> </p>
			
				<!-- <h3 id="track"> Track your grades online </h3> -->
			
			</div> <!-- branding -->
					
			