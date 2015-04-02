<?php require_once("classes/sessionadmin.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/gwa.php");?>
<?php include_once("functions/function.php");?>
<?php require_once("fpdf/fpdf.php") ?>
<?php  
 	
		if (!$sessionadmin->is_logged_in()) { //if the user is not logged in
		
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
		
		$this->Cell(197,5,'Republic of the Philippines',0,2,'C'); // width,height,text,border,linebreak is 2, alignment
		$this->Cell(197,5,'Southern Luzon State University',0,2,'C');
		$this->Cell(197,5,'College of Industrial Technology',0,2,'C');
		$this->Cell(197,5,'Lucban, Quezon',0,2,'C');
		
		$this->Ln(4);
		
		$this->SetFont('Arial','',10); //set the font, font-weight, size
		$this->Cell(214,5,$rows['firstname'] . " " . $rows['middlename'] . " " . $rows['lastname'] . " | " . 'BSIT - Computer Technology' . " | " . $rows['year'],0,2,'C');
		
		$this->Ln(1);
		
		
	}
	
	private function textoverflow($subjectdescription) {
	
		if (strlen($subjectdescription) >= 45) {
			
			$output = $this->Cell(55,4,substr($subjectdescription,0,42) . "..." ,1,0,'L');
			
		} else {
			
			$output = $this->Cell(55,4,$subjectdescription,1,0,'L');
			
		}
		
	return $output;
	
	}
	
	public function theTable($x, $y, $studentid) {
		
		$y;
		$row;
		$x;
		
		$sql  = "SELECT DISTINCT studentid, acadyear, semester FROM tblgrade ";
		$sql .= " WHERE studentid = " . $studentid . " AND acadyear != '' ";
		$sql .= " ORDER BY acadyear ";
						
		$theAcadYear = Grade::find_by_sql($sql);
	
			foreach ($theAcadYear as $year) {
			
				
				$this->SetFont('Arial','B',8.5); //set the font, font-weight, size
				
				$this->SetXY($x,$y);	
				$this->Cell(87,4,$year->semester . " A.Y - " . $year->acadyear,0,2,'L');
				$this->SetFont('Arial','B',6.5); //set the font, font-weight, size
				$this->Cell(17,4,'CODE',1,0,'L');
				$this->Cell(55,4,'DESCRIPTION',1,0,'L');
				$this->Cell(10,4,'UNIT(S)',1,0,'C');
				$this->Cell(12,4,'RATING',1,1,'C');
				
				
				$sql2  = 	"SELECT DISTINCT tblgrade.entryid, lastname, firstname, middlename, credit, year, pix, offered, tblstudent.studentid, tblsubject.subjectcode, ";
				$sql2 .=  	"tblsubject.subjectdesc, unit, grade, semester, acadyear ";
				$sql2 .=	"FROM tblstudent INNER JOIN ( tblgrade INNER JOIN tblsubject ";
				$sql2 .=	"ON tblgrade.subjectcode = tblsubject.subjectcode ) ";
				$sql2 .=	"ON tblstudent.studentid = tblgrade.studentid ";
				$sql2 .=	"WHERE tblstudent.studentid = " . $studentid . " AND acadyear = " . "'" . $year->acadyear . "'" . " AND semester = " . "'" . $year->semester . "'";
				$sql2 .=    " AND (grade = '1.00' OR grade = '1.25' OR grade = '1.50' OR grade = '1.75' OR grade = '2.00' OR grade = '2.25' OR grade = '2.50' OR grade = '2.75' OR grade = '3.00' OR grade = '4.00' OR grade = '5.00' OR grade = 'DRP') ";
				$sql2 .=  	" ORDER BY acadyear, semester, entryid ";
		
				$theGrade = Grade::find_by_sql($sql2);
			
				foreach ($theGrade as $grade) {

					if ($grade->grade == '5.00' OR $grade->grade == '4.00' OR $grade->grade == 'DRP') {

						$this->SetTextColor(221,0,0);
				    }
					
						$this->SetFont('Arial','',6.5); //set the font, font-weight, size
						$this->SetX($x);	
						$this->Cell(17,4,$grade->subjectcode,1,0,'L');
						$this->textoverflow($grade->subjectdesc);


						
						if ($grade->credit == 0) {
			
							$this->Cell(10,4,"(" . $grade->unit . ")",1,0,'C');
			
						} else {
			
							$this->Cell(10,4,$grade->unit,1,0,'C');
			
						}



			
						if ($grade->grade == "5.00" || $grade->grade == "4.00" OR $grade->grade == "DRP") {
						
							$this->SetTextColor(221,0,0);
							$this->Cell(12,4,$grade->grade,1,1,'C');
							$this->SetTextColor(0,0,0);
						
						} else {
			
							$this->SetTextColor(0,0,0);
							$this->Cell(12,4,$grade->grade,1,1,'C');
				
			
						}

			
						$row = $row + 4.5;
						$y1 = $y1 + 3;

				} //foreach
			
				$x = $x + 105;


				
				if ($x != 115) {
						
					$x = 10;
					$y = $y + 58;
				
				}



		}

		
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