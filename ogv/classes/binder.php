<?php

require_once("mysql.php");

class Binder extends MySQLDatabase {

	public function populate_combobox($table_name , $value, $label, $sort) {
		
		$query_bind = "SELECT * FROM " . $table_name . " ORDER BY " . $sort . " ASC ";
		
		$result_bind = parent::query($query_bind);
										
		while ($bind = parent::fetch_array($result_bind)) {
										
			$output .= "<option value=\"" . $bind[$value] . "\">" . $bind[$label] . "</option>";
													
		}
	
		return $output;
	
	}
	
	
	public function populate_comboboxskip($table_name , $value, $label, $sort, $studentid) {
		
		$query_bind  = "SELECT * FROM " . $table_name;
		$query_bind .= " WHERE studentid = $studentid AND (grade = '' OR grade = '0.00' OR grade = 'DRP' OR grade = '5.00') ";
		$query_bind .= " ORDER BY " . $sort . " ASC ";
		
		$result_bind = parent::query($query_bind);
										
		while ($bind = parent::fetch_array($result_bind)) {
										
			$output .= "<option value=\"" . $bind[$value] . "\">" . $bind[$label] . "</option>";
													
		}
	
		return $output;
	
	}
	

	public function selectCurrent($table_name , $value, $label, $sort, $match) {
		
		$query_bind = "SELECT * FROM " . $table_name . " ORDER BY " . $sort . " ASC ";
		
		$result_bind = parent::query($query_bind);
										
		while ($bind = parent::fetch_array($result_bind)) {
										
			$output .= "<option value=\"" . $bind[$value] . "\"";
			
						if ($bind[$value] == $match) {
						
							$output .= " selected=\"selected\"";
						
						}
						
			$output .= ">" . $bind[$label];
			
			$output .= "</option>";
													
		}
	
		return $output;
	
	}
	
	public function selectCurrentNonDB($match) {
	
		$theArray = array('0.00','1.00','1.25','1.50','1.75','2.00','2.25','2.50','2.75','3.00','4.00','5.00','DRP');
	
		foreach ($theArray as $array) {
		
			$output .= "<option value=\"" . $array . "\" ";
			
			if ($array == $match) {
			
				$output .= "selected=\"selected\"";
			
			}
			
			$output .= ">" . $array . "</option>";
			
		
		}

	
		return $output;
	
	}
	
	public function selectCurrentNonDB2($fetchedarray, $match) {
	
		$theArray = $fetchedarray;
	
		foreach ($theArray as $array) {
		
			$output .= "<option value=\"" . $array . "\" ";
			
			if ($array == $match) {
			
				$output .= "selected=\"selected\"";
			
			}
			
			$output .= ">" . $array . "</option>";
			
		
		}
		
		return $output;
		
	}
		
}
	
$binder = new Binder();	
	
?>