<?php
require_once('mysql.php');

class GWA {

	public $apparentsumofunits;
	public $apparentsumofproducts;

	public $sumofunits;
	public $sumofproducts;
	
	public $sumofunits2;
	public $sumofproducts2;
	
	public $apparentgwa;
	public $thegwa;
	public $thegwa2;
	
	
	public function gwarating($grade,$credit) {
		
		$partialproducts = ((double)$grade) * ((double)$credit);
		
		$this->sumofproducts = $this->sumofproducts + $partialproducts;
		
		if ($grade == '0.00' || $grade == 'DRP' || $grade == 0) {
		
			$units = 0;
			
		
		} else {
		
			$units = (double)$credit;
			
		}
		
		if ($this->sumofunits == 0) {
		
			$this->sumofunits = NULL;
		
		}
		
		$this->sumofunits = $this->sumofunits + $units;	
		
		if ($this->sumofunits == 0) {
		
			$this->thegwa = (0 / 1);
		
		} else {
			
			$this->thegwa = ($this->sumofproducts / $this->sumofunits);
		
		}
			 
	}
	
	public function apparentgwarating($grade,$unit) {
		
		$partialproducts = ((double)$grade) * ((double)$unit);
		
		$this->apparentsumofproducts = $this->apparentsumofproducts + $partialproducts;
		
		if ($grade == '0.00' || $grade == 'DRP' || $grade == 0) {
		
			$units = 0;
			
		
		} else {
		
			$units = (double)$unit;
			
		}
		
		if ($this->apparentsumofunits == 0) {
		
			$this->apparentsumofunits = NULL;
		
		}
		
		$this->apparentsumofunits = $this->apparentsumofunits + (double)$units;	
		
		if ($this->apparentsumofunits == 0) {
		
			$this->apparentgwa = (0 / 1);
		
		} else {
			
			$this->apparentgwa = ($this->apparentsumofproducts / $this->apparentsumofunits);
		
		}
			 
	}
	
	public function gwarating2($grade,$credit) {
	
		
		$partialproducts2 = ((double)$grade) * ((double)$credit);
		$this->sumofproducts2 = $this->sumofproducts2 + $partialproducts2;
		
		if ($grade == 0) { //if grade is blank set unit value to 0
		
			$units = 0;
		
		} else {
		
			$units = (double)$credit;	
		}
		
		$this->sumofunits2 = $this->sumofunits2 + $units;	
		
		if ($this->sumofunits2 == 0) {
		
			$this->thegwa2 = (0 / 1); //if sumofunits is 0, then prevent the gwa by division of 0 error
		
		} else {
			
			$this->thegwa2 = ($this->sumofproducts2 / $this->sumofunits2);
		
		}
			 
	}

}
$gwa = new GWA();
?>