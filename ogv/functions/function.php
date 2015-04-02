<?php
	
	function redirect_to($location = NULL) {
	
		if ($location != NULL) {
		
			header("Location:{$location}");
	
		}
	}
	
	function check_required_fields($required_array) {
		
		$field_errors = array();
			
		foreach($required_array as $fieldname) {
			         
			if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]))) {
			
					$field_errors[] = $fieldname; // store error
					
			} 
						
		} // end foreach
			
		return $field_errors;
		
	}
	
	function createlabels() {
	
		$output .= "<tr>";
									
			$output .= "<td class='code'> CODE </td> ";
			$output .= "<td class='description'> DESCRIPTION </td> ";
			$output .= "<td class='unit'> UNIT </td> ";
			$output .= "<td class='rating'> RATING </td> ";
	
		$output .= "</tr>";
		
		return $output;
	
	}
	

	function createlabelstudent() {
	
		$output .= "<tr>";
									
			$output .= "<td class='description'> NAME </td> ";
			$output .= "<td class='code'> YEAR LEVEL </td> ";
			//$output .= "<td class='unit'> &nbsp; </td> ";
			//$output .= "<td class='rating'> &nbsp; </td> ";
	
		$output .= "</tr>";
		
		return $output;
	
	}
	
	function createlabelstudent2() {
	
		$output .= "<tr>";
									
			$output .= "<td class='description'> NAME </td> ";
			$output .= "<td class='code'> YEAR LEVEL </td> ";
			$output .= "<td class='unit'> &nbsp; </td> ";
			$output .= "<td class='unit'> &nbsp; </td> ";
	
		$output .= "</tr>";
		
		return $output;
	
	}
	
	function semester() {
	
		$output .= "<tr class='semester'>";
			
			$output .= "<td colspan='4' class='bold'> First Semester </td>";
		
		$output .= "</tr>";
		
		return $output;
	
	}
	
	function semester2() {
	
		$output .= "<tr class='semester'>";
			
			$output .= "<td colspan='4' class='bold'> Second Semester </td>";
		
		$output .= "</tr>";
		
		return $output;
	
	}
	
	function summer() {
	
		$output .= "<tr class='semester'>";
			
			$output .= "<td colspan='4' class='bold'> Summer </td>";
		
		$output .= "</tr>";
		
		return $output;
	
	}
?>