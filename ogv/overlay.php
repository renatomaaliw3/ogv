<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/useradmin.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/gwa.php");?>
<?php require_once("classes/binder.php");?>
<?php include_once("functions/function.php"); ?>
<?php  
 	
		if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
			redirect_to("login.php");
			exit;
		
		}
		
?>			
<?php  

$entryid = $_GET['entryid'];
$_SESSION['studentid'] = $studentid;

$sql  =  "SELECT tblgrade.entryid, tblgrade.studentid, lastname, firstname, middlename, pix, tblsubject.subjectcode, ";
$sql .=  "tblsubject.subjectdesc, unit, credit, grade, semester, acadyear ";
$sql .=	 "FROM tblstudent INNER JOIN ( tblgrade INNER JOIN tblsubject ";
$sql .=	 "ON tblgrade.subjectcode = tblsubject.subjectcode ) ";
$sql .=	 "ON tblstudent.studentid = tblgrade.studentid ";
$sql .=	 "WHERE tblgrade.entryid = " . $entryid . " LIMIT 1 ";
	 
$theGrade = Grade::find_by_sql($sql);

?>

<p class="close"> Close </p>

<?php foreach ($theGrade as $grade) { ?>

<form action="executeupdate.php" method="post" id="update_form">

<table class="details">
							
		<?php 
		
			echo "<tr>";
				
				echo "<td class='code' style='width:83px;'> CODE </td> ";
				echo "<td class='code' style='width:105px;'> DESCRIPTION </td> ";
				echo "<td class='unit' style='width:110px;'> SEMESTER </td> ";
				echo "<td class='rating'> ACAD YEAR </td> ";
				echo "<td class='rating'> UNITS </td> ";
				echo "<td class='rating'> RATING </td> ";

			echo "</tr>";
										
		?>
	
		<tr>
			<input type="hidden" name="entryid" id="entryid" value="<?php echo $grade->entryid;?>">
			<input type="hidden" name="studentid" id="studentid" value="<?php echo $grade->studentid;?>">
			<td class="leftalign"><?php echo $grade->subjectcode; ?></td>
			<td class="leftalign"><?php echo $grade->subjectdesc; ?></td>
			<td>
			
				<select id="semester" name="semester" style="font-size:0.95em;">
					<?php $fetchedarray = array('','1st Semester','2nd Semester','Summer');?>
					<?php echo $binder->selectCurrentNonDB2($fetchedarray, $grade->semester); ?>
				</select>
			
			</td>
			<td>
			
				<select id="acadyear" name="acadyear" style="font-size:0.95em;">
				
					<?php 
						$array1 = array('','2005 to 2006','2006 to 2007','2007 to 2008','2008 to 2009','2009 to 2010','2010 to 2011');
						$array2 = array('2011 to 2012','2012 to 2013','2013 to 2014','2014 to 2015');
					?>
					
					<?php $fetchedarray = array_merge($array1,$array2);?>
					<?php echo $binder->selectCurrentNonDB2($fetchedarray, $grade->acadyear); ?>
					
				</select>
			
			</td>
			<td>
			<?php 
			
				if ($grade->credit == 0) {
			
					echo "(" . $grade->unit . ")"; 
					
				} else {
				
					echo $grade->unit; 
					
				}
									
			?></td>
			<td>
			<select name="grade" id="grade" style="font-size:1em;">
								
				<?php echo $binder->selectCurrentNonDB($grade->grade); ?>
			
			</select>
			</td>
			<td class="update"><input type="submit" name="submit" id="submit" value="SAVE" style="font-size:1em;"/></td>
		</tr>
		
</table>

</form>	

<?php  } ?>

