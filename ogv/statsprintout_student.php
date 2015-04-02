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
		
		$this->Cell(197,5,'Republic of the Philippines',0,2,'C'); // width,height,text,border,linebreak is 2, alignment
		$this->Cell(197,5,'Southern Luzon State University',0,2,'C');
		$this->Cell(197,5,'College of Industrial Technology',0,2,'C');
		$this->Cell(197,5,'Lucban, Quezon',0,2,'C');
		
		$this->Ln(4);
		
		$this->SetFont('Arial','',12); //set the font, font-weight, size
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

	
	private function count_grades($grade, $studentid) {
	
		global $database;
	
		$sql = "SELECT COUNT(grade) FROM tblgrade WHERE studentid = " . $studentid . " AND grade = '$grade' ";
		$result = $database->query($sql);
		$row = $database->fetch_array($result);
		
		return array_shift($row);
	
	
	}
	
	private function count_all_grades($studentid) {
	
		global $database;
	
		$sql  = "SELECT COUNT(grade) FROM tblgrade WHERE studentid = " . $studentid;
		$sql .= " AND (grade = '1.00' OR grade = '1.25' OR grade = '1.50' OR grade = '1.75' OR grade = '2.00' OR grade = '2.25' OR grade = '2.50' OR grade = '2.75' OR grade = '3.00' OR grade = '4.00' OR grade = '5.00' OR grade = 'DRP') ";
		$result = $database->query($sql);
		$row = $database->fetch_array($result);
		
		return array_shift($row);
	
	
	}
	
	public function theGradeStats($studentid) {
	
		$count_of_all_grades = $this->count_all_grades($studentid);
		
		$theGradeArray = array('1.00','1.25','1.50','1.75','2.00','2.25','2.50','2.75','3.00','4.00','5.00','DRP');
	
			$this->Ln(10);
			$this->SetFont('Arial','B',12); //set the font, font-weight, size
			
			$this->Cell(32,6,'',0,0,'L');
			$this->Cell(35,6,"RATING",1,0,'C');
			$this->Cell(55,6,"COUNT",1,0,'C');
			$this->Cell(55,6,"PERCENTAGE",1,1,'C');
			
	
			$this->SetFont('Arial','',12); //set the font, font-weight, size
			
			foreach ($theGradeArray as $grades) {
			
				$count_grade = 0;
			
				$this->Cell(32,6,'',0,0,'L');
				
				if ($grades == '5.00' || $grades == '4.00' || $grades == 'DRP') {
				
					$this->SetTextColor(221,0,0);
					$this->Cell(35,6,$grades,1,0,'C');
					
				} else {
				
					$this->SetTextColor(0,0,0);
					$this->Cell(35,6,$grades,1,0,'C');
				
				}
				
				$count_grade = $this->count_grades($grades, $studentid);
				
				$this->Cell(55,6,$count_grade,1,0,'C');
				$this->Cell(55,6,number_format(((($count_grade)/ ($count_of_all_grades)) * 100), 2) . " % ",1,1,'C');
	
			}
	
	
	}
	
	public function theGradeByCat($studentid) {
	
		global $gwa;
	
		$theArrayCat = array(1=>'Professional Subject',2=>'Mathematics',3=>'English',4=>'Filipino',5=>'Natural Science',6=>'Social Science',7=>'Related Subjects',8=>'Physical Education',9=>'NSTP');
	
			$this->SetTextColor(0,0,0);
			
			$this->Ln(10);
			$this->SetFont('Arial','B',12); //set the font, font-weight, size	
			$this->Cell(32,6,'',0,0,'L');
			$this->Cell(90,6,"CATEGORY",1,0,'L');
			$this->Cell(55,6,"GWA",1,1,'C');
		
			
	
			$this->SetFont('Arial','',12); //set the font, font-weight, size
			
			foreach ($theArrayCat as $cat=>$value) {
			
				$this->Cell(32,6,'',0,0,'L');
				$this->Cell(90,6,$value,1,0,'L');
				
				$gwa->sumofunits = 0;
				$gwa->sumofproducts = 0;
				$gwa->thegwa = 0;
				
				$gwa->apparentsumofunits = 0;
				$gwa->apparentsumofproducts = 0;
				$gwa->apparentgwa = 0;

				
				$sql2  = 	"SELECT * FROM tblgrade ";	
				$sql2 .=    "INNER JOIN tblsubject ";
				$sql2 .=	"ON tblgrade.subjectcode = tblsubject.subjectcode ";
				$sql2 .=	"WHERE studentid = " . $studentid . " AND catid = " . $cat;
				$sql2 .=	" AND (grade = '1.00' OR grade = '1.25' OR grade = '1.50' OR grade = '1.75' OR grade = '2.00' OR grade = '2.25' OR grade = '2.50' OR grade = '2.75' OR grade = '3.00' OR grade = '4.00' OR grade = '5.00' OR grade = 'DRP') ";
				
				$theGrade = Grade::find_by_sql($sql2);
				
				foreach ($theGrade as $grade) { 
				
					$gwa->gwarating($grade->grade,$grade->credit);
					$gwa->apparentgwarating($grade->grade,$grade->unit);
		
									
				}
				
			$this->Cell(55,6,number_format($gwa->thegwa,3) . " (" . number_format($gwa->apparentgwa,3) . ")",1,1,'C');
		
			}
	
	
	}	
		
	
	function url_link() {

		$this->SetTextColor(0,0,0);
 		$this->SetFont('Courier','',7); //set the font, font-weight, size
    	$this->setXY(9.5, 320);
 		$this->Cell(195,2,'BSIT - Computer Technology Online Grade Viewer, Copyright 2014');
	 		

	}

	function Footer() {

		$this->SetTextColor(0,0,0);
 		$this->SetFont('Courier','',7); //set the font, font-weight, size
    	$this->setXY(9.5, 324);
    	$this->Cell(195,2,'http://www.cptgrades.herobo.com/');
 		
 	
	}

}
	
$pdf = new Report('P','mm','Legal'); //paper size
$pdf->theHeader($studentid);
$pdf->theGradeByCat($studentid);
$pdf->theGradeStats($studentid);
$pdf->url_link();
$pdf->Footer();

$pdf->Output(); //render the page to a PDF File
?>