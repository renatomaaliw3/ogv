<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/gwa.php");?>
<?php include_once("functions/function.php");?>
<?php require_once("fpdf/fpdf.php") ?>
<?php  
 	
		if (!$session->is_logged_in()) { //if the user is not logged in
		
			redirect_to("index.php");
			exit;
		
		}

		$studentid = $_GET['studentid'];

?>
<?php

class Report extends FPDF {

	function __construct($orientation, $unit, $size) {
		
		parent::__construct($orientation, $unit, $size); //overwrite parent constructor
		$this->AddPage();
		$this->SetMargins(1,1,1);
		
	}
	
	public function theHeader($studentid) {
	
		global $database;
		
		$sql = "SELECT * FROM tblstudent WHERE studentid = " . $studentid;
		$result_set = $database->query($sql);
		$rows = $database->fetch_array($result_set);
	
		//$this->Image('images/slsu.jpg',29,7,16,16); //attach image
		$this->SetFont('Arial','B',10); //set the font, font-weight, size
		
		$this->Cell(197,4,'Republic of the Philippines',0,2,'C'); // width,height,text,border,linebreak is 2, alignment
		$this->Cell(197,4,'Southern Luzon State University',0,2,'C');
		$this->Cell(197,4,'College of Industrial Technology',0,2,'C');

		$this->Cell(197,4,'Lucban, Quezon',0,2,'C');

		$this->SetFont('Courier','B',12); 

		$this->Cell(197,10,'Rating Evaluation',0,2,'C');

		
		$this->SetFont('Arial','',10); //set the font, font-weight, size
		$this->Text(10,40, "Name:      " . $rows['firstname'] . " " . $rows['middlename'] . " " . $rows['lastname']);
		$this->Text(10,45,"Course:    BSIT - Computer Technology");
		$this->Text(150,40,"Year:    " .    $rows['year']);

		
	}
	
	private function textoverflow($subjectdescription) {
	
		if (strlen($subjectdescription) >= 45) {
			
			$output = $this->Cell(55,4.5,substr($subjectdescription,0,42) . "..." ,1,0,'L');
			
		} else {
			
			$output = $this->Cell(55,4.5,$subjectdescription,1,0,'L');
			
		}
		
	return $output;
	
	}
	
	public function theTable($x, $y, $studentid) {
		
		$y;
		$row;
		$x;
		$tablecount = 1;
		$semcount = 0;
		// $sql  = "SELECT DISTINCT studentid, acadyear, semester FROM tblgrade ";
		// $sql .= " WHERE studentid = " . $studentid . " AND offered != ''";
		// $sql .= " ORDER BY offered ";


		$sql  =  "SELECT DISTINCT offered FROM tblsubject ";
		$sql .=  "GROUP BY offered ";
		$sql .=  "ORDER BY offered ";

		
		$theAcadYear = Grade::find_by_sql($sql);
	
			foreach ($theAcadYear as $year) {

				$year_and_sem = array('FIRST YEAR - 1ST SEMESTER', 'FIRST YEAR - 2ND SEMESTER');
				$year_and_sem2 = array('SECOND YEAR - 1ST SEMESTER', 'SECOND YEAR - 2ND SEMESTER', 'SECOND YEAR - SUMMER');
				$year_and_sem3 = array('THIRD YEAR - 1ST SEMESTER', 'THIRD YEAR - 2ND SEMESTER');
				$year_and_sem4 = array('FOURTH YEAR - 1ST SEMESTER', 'FOURTH YEAR - 2ND SEMESTER');

				$merge_sems = array_merge($year_and_sem, $year_and_sem2, $year_and_sem3, $year_and_sem4);

			
				$this->SetFont('Arial','B',9); //set the font, font-weight, size
				
				$this->SetXY($x,$y); //initial location x = 10, y = 50	
				
				//this is the field headers

				$this->SetFont('Arial','B',8); //set the font, font-weight, size

				$this->Cell(95,5,$merge_sems[$semcount],1,2,'L');

				$this->Cell(18,4,'Code',1,0,'L');
				$this->Cell(55,4,'Description',1,0,'L');
				$this->Cell(10,4,'Unit',1,0,'C');
				$this->Cell(12,4,'Rating',1,1,'C');
				
				$sql2  = "SELECT DISTINCT studentid, tblsubject.subjectcode, subjectdesc, grade, credit, offered, unit FROM tblsubject ";
				$sql2 .= "INNER JOIN tblgrade ";
				$sql2 .= "ON tblsubject.subjectcode = tblgrade.subjectcode ";
				$sql2 .= "WHERE (studentid = '" . $studentid . "' AND offered = '" . $year->offered . "') " ;
				$sql2 .= "ORDER BY offered, tblsubject.entryid ";
		
				$theGrade = Grade::find_by_sql($sql2);
			
					foreach ($theGrade as $grade) {

						if ($grade->grade == '5.00' OR $grade->grade == '4.00' OR $grade->grade == 'DRP') { 

							$this->SetTextColor(221,0,0);

						}

							$this->SetFont('Arial','',7); //set the font, font-weight, size
							$this->SetX($x); //first run is	x = 10, for subject details

							$this->Cell(18,4.5,$grade->subjectcode,1,0,'L'); // width and height
							$this->textoverflow($grade->subjectdesc); //check for long subject descriptions restrict to certain string length
							
							if ($grade->credit == 0) {
				
								$this->Cell(10,4.5,"(" . $grade->unit . ")",1,0,'C');
				
							} else {
				
								$this->Cell(10,4.5,$grade->unit,1,0,'C');
				
							}
				
							if ($grade->grade == "5.00" || $grade->grade == "4.00" || $grade->grade == 'DRP') {
							
								$this->Cell(12,4.5,$grade->grade,1,1,'C');
								$this->SetTextColor(0,0,0);
							
							} else {
				
								$this->SetTextColor(0,0,0);
								$this->Cell(12,4.5,$grade->grade,1,1,'C');
					
				
							}
	

						}

								
						$x = $x + 100; // 10 + 105 = 115 -> location of second semesters
						
						if ($x != 110) {
							
							$x = 10; //set to $x = 10 -> location of 1st semesters
							$y = $y + 71; //vertical distances

						}

						if ($tablecount == 4) {

							$x = 60;
							$y = 178;
			
						} else if ($tablecount == 5) {

							$x = 10;
							$y = 200;
						} 


						$tablecount++;
						$semcount++;	
				
		} //foreach grade




		
	}

		function url_link() {

	 		$this->SetFont('Courier','',7); //set the font, font-weight, size
	    	$this->setXY(9.5, 320);
	 		$this->Cell(195,2,'BSIT - Computer Technology Online Grade Viewer, Copyright 2014');
	 		

		}

		function Footer() {

	 		$this->SetFont('Courier','',7); //set the font, font-weight, size
	    	$this->setXY(9.5, 324);
	    	$this->Cell(195,2,'http://www.cptgrades.herobo.com/');
	 		
	 	
		}


}
	
$pdf = new Report('P','mm','Legal'); //paper size
$pdf->theHeader($studentid);
$pdf->theTable(10,50, $studentid);
$pdf->url_link();
$pdf->Footer();


$pdf->Output(); //render the page to a PDF File
?>