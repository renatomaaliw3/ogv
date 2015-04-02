<?php require_once("classes/session.php");?>
<?php require_once("classes/mysql.php");?>
<?php require_once("classes/user.php");?>
<?php require_once("classes/grade.php");?>
<?php require_once("classes/gwa.php");?>
<?php include_once("functions/function.php");?>
<?php require_once("fpdf/fpdf.php") ?>
<?php  
 	
		if (!$session->is_logged_in()) { //if the user is not logged in
		
			redirect_to("login.php");
			exit;
		
		}
		
?>
<?php

class Report extends FPDF {

	function __construct($orientation, $unit, $size) {
		
		parent::__construct($orientation, $unit, $size); //overwrite parent constructor
		$this->AddPage();
		$this->SetMargins(1,1,1);
		
	}
	
	public function theHeader() {
	
		global $database;
		
		$sql = "SELECT * FROM tblstudent WHERE studentid = " . $_SESSION['studentid'];
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
	
	public function theTable($yearoffered, $start, $finish, $x, $y) {
		
		$y;
		
		$sql  =  "SELECT lastname, firstname, middlename, credit, year, pix, offered, tblstudent.studentid, tblsubject.subjectcode, ";
		$sql .= "tblsubject.subjectdesc, unit, grade ";
		$sql .=	 "FROM tblstudent INNER JOIN ( tblgrade INNER JOIN tblsubject ";
		$sql .=	 "ON tblgrade.subjectcode = tblsubject.subjectcode ) ";
		$sql .=	 "ON tblstudent.studentid = tblgrade.studentid ";
		$sql .=	 "WHERE tblstudent.studentid = " . $_SESSION['studentid'] . " AND offered = '{$yearoffered}' LIMIT {$start}, {$finish}";
	
		$theGrade = Grade::find_by_sql($sql);
					
		$this->SetFont('Arial','B',6.5); //set the font, font-weight, size
		$this->SetTextColor(7,18,143);
		$this->SetXY($x,$y);
		$this->Cell(17,4,'CODE',1,0,'L');
		$this->Cell(55,4,'DESCRIPTION',1,0,'L');
		$this->Cell(12,4,'UNIT(S)',1,0,'C');
		$this->Cell(12,4,'RATING',1,2,'C');
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',6.5);

		
		foreach ($theGrade as $grade) {
		
			$this->SetXY($x,$y+4.5);
			
			$this->Cell(17,4,$grade->subjectcode,1,0,'L');
			
			$this->textoverflow($grade->subjectdesc);
			
			if ($grade->credit == 0) {
			
				$this->Cell(12,4,"(" . $grade->unit . ")",1,0,'C');
			
			} else {
			
				$this->Cell(12,4,$grade->unit,1,0,'C');
			
			}
			
			if ($grade->grade == "5.00" || $grade->grade == "4.00") {
			
				$this->SetTextColor(221,0,0);
				$this->Cell(12,4,$grade->grade,1,1,'C');
				$this->SetTextColor(0,0,0);
			
			} else {
			
				$this->SetTextColor(0,0,0);
				$this->Cell(12,4,$grade->grade,1,1,'C');
				
			
			}
			
			
			$y = $y + 4.5;
		
		}
			
	}
	
	

}
$pdf = new Report('P','mm','Letter'); //paper size
$pdf->theHeader();

$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(10,48,'1st Year - 1st Sem');
$pdf->theTable('1',0,9,10,50);

$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(112,48,'1st Year - 2nd Sem');
$pdf->theTable('1',9,9,112,50);


$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(10,103,'2nd Year - 1st Sem');
$pdf->theTable('2',0,8,10,105);

$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(112,103,'2nd Year - 2nd Sem');
$pdf->theTable('2',8,8,112,105);

$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(103,150,'Summer');
$pdf->theTable('2',16,1,62,152);

$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(10,168,'3rd Year - 1st Sem');
$pdf->theTable('3',0,7,10,170);

$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(112,168,'3rd Year - 2nd Sem');
$pdf->theTable('3',7,6,112,170);

$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(10,214,'4th Year - 1st Sem');
$pdf->theTable('4',0,6,10,216);

$pdf->SetFont('Arial','B',8.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(112,214,'4th Year - 2nd Sem');
$pdf->theTable('4',6,1,112,216);

$pdf->Output(); //render the page to a PDF File
?>