<?php

require_once('mysql.php'); 
	
class Grade {
	
	protected static $table_name="tblgrade";
	protected static $table_student="tblstudent";
	
	public static $db_fields_student = array('lastname','firstname','middlename','year','username','passkey'); //database fields
	public static $db_fields_grades = array('grade','semester','acadyear');
	public static $db_fields_retake = array('studentid','subjectcode','grade','semester','acadyear');
	
	public $entryid;
	public $studentid;
	public $subjectcode;
	public $subjectdesc;
	public $unit;
	public $credit;
	public $grade;
	public $semester;
	public $acadyear;
	public $offered;
	public $catid;
	
	public $lastname;
	public $firstname;
	public $middlename;
	public $year;
	public $username;
	public $passkey;
	
	
	public $pix;
	
			
	public static function find_by_sql($sql) {
	
		global $database;
		
		$result_set = $database->query($sql);
		$object_array = array();
		
		while ($record = $database->fetch_array($result_set)) {
			
			$object_array[] = self::instantiate($record);
		
		}
	
		return $object_array;
		
	}
	
	public static function count_all() {
	
		global $database;
		$sql = "SELECT COUNT(*) FROM " . self::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
		
	}
	
	public static function count_search($sql) {

		global $database;

		$result_set = $database->query($sql);
		$row = $database->num_rows($result_set);
		return $row;
		

	}

	public static function count_search_results($yearlevel) {
	
		global $database;
			
		if ($yearlevel == "All Year") {	
			
			$sql = "SELECT COUNT(*) FROM tblstudent ORDER BY lastname, firstname, middlename ";
		
		} else {
		
			$sql = "SELECT COUNT(*) FROM tblstudent WHERE year = '$yearlevel' ORDER BY lastname, firstname, middlename ";
		
		}
		
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		
		return array_shift($row);
	
	
	}
	
	public static function count_subjects($studentid, $acadyear, $semester, $yearoffered) {
	
		global $database;
			
		$sql2  = 	"SELECT COUNT(*) ";
		$sql2 .=	"FROM tblstudent INNER JOIN ( tblgrade INNER JOIN tblsubject ";
		$sql2 .=	"ON tblgrade.subjectcode = tblsubject.subjectcode ) ";
		$sql2 .=	"ON tblstudent.studentid = tblgrade.studentid ";
		$sql2 .=	"WHERE tblstudent.studentid = " . $studentid . " AND acadyear = " . "'" . $acadyear . "'" . " AND semester = " . "'" . $semester . "' AND offered LIKE '%$yearoffered%' " ;
		$sql2 .=    " AND (grade = '1.00' OR grade = '1.25' OR grade = '1.50' OR grade = '1.75' OR grade = '2.00' OR grade = '2.25' OR grade = '2.50' OR grade = '2.75' OR grade = '3.00' OR grade = '4.00' OR grade = '5.00' OR grade = 'DRP') ";
		$sql2 .=  	" ORDER BY acadyear, semester, tblgrade.entryid ";
		
		$result_set = $database->query($sql2);
		$row = $database->fetch_array($result_set);
		
		return array_shift($row);
	
	
	}
	
	public static function count_passed_subjects($studentid) {
			
		global $database;
			
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM tblgrade WHERE studentid = $studentid ";
		$sql .= " AND (grade = '1.00' OR grade = '1.25' OR grade = '1.50' OR grade = '1.75' OR grade = '2.00' OR grade = '2.25' OR grade = '2.50' OR grade = '2.75' OR grade = '3.00') ";
		
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		
		return array_shift($row);
	
	
	}

	public static function count_failed_subjects($studentid) {
			
		global $database;
			
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM tblgrade WHERE studentid = $studentid ";
		$sql .= " AND (grade = '5.00')";
		
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		
		return array_shift($row);
	
	}

	public static function count_conditional_subjects($studentid) {
			
		global $database;
			
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM tblgrade WHERE studentid = $studentid ";
		$sql .= " AND (grade = '4.00')";
		
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		
		return array_shift($row);
	
	}

	public static function count_dropped_subjects($studentid) {
			
		global $database;
			
		$sql  = "SELECT COUNT(*) ";
		$sql .= "FROM tblgrade WHERE studentid = $studentid ";
		$sql .= " AND (grade = 'DRP')";
		
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		
		return array_shift($row);
	
	}



	
	private static function instantiate($record) {
	
		$object = new self();
	
		foreach ($record as $attribute=>$value) {
		
			if ($object->has_attribute($attribute)) {
			
				$object->$attribute = $value;
			
			}
		
		}
		
		return $object;
		
	}
	
	private function has_attribute($attribute) {
	
		$object_vars = get_object_vars($this);
		return array_key_exists($attribute, $object_vars);
	
	}
		
	public function attributes($fields) {
	
		// returns an array of attribute keys and their values
		$attributes = array();
		foreach (self::${$fields} as $field) {
		
			if (property_exists($this, $field)) {
			
				$attributes[$field] = $this->$field;
			
			}
		
		}
		return $attributes;
	
	}
	
	private function sanitized_attributes($fields) {
	
		global $database;
		$clean_attributes = array();
		
		foreach ($this->attributes($fields) as $key => $value) {
			
			$clean_attributes[$key] = $database->mysql_prep($value);
		
		}
		return $clean_attributes;
	
	}
	
	public function setgradesheet($studentid) {
	
		global $database; //$database is the instance of the MySQLDatabase class
		
		$sql = "SELECT * FROM tblsubject ";
		$result_set = $database->query($sql);	
	
	
		while ($thesubject = $database->fetch_array($result_set)) {
	
			$sql  = "INSERT INTO tblgrade (studentid,subjectcode) VALUES ";
			$sql .= "($studentid," . "'" . $thesubject['subjectcode'] . "')";
		
			$database->query($sql);
		
		}
	
	}
	
	/*
	public function updategrade($entryid) {
	
		global $database;
		
		$sql = "UPDATE tblgrade SET grade = " . "'" . $this->grade . "'" . " WHERE entryid = " . $entryid;
		
		$database->query($sql);
	
	}
	*/
	
	public static function fullname() {
	
		return self::$firstname . " " . self::$middlename . " " . self::$lastname;
	
	}
	
	public function addretake($fields) {
	
		global $database; //$database is the instance of the MySQLDatabase class
		
		$attributes = $this->sanitized_attributes($fields);
		
		$sql  = "INSERT INTO " . self::$table_name . " (";
		$sql .= join(",", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		
		$database->query($sql);
	
	}
	
	public function updategrade($fields) {
	
		global $database;
		
		global $database;
		
		$attributes = $this->sanitized_attributes($fields);
		$attribute_pairs = array();
		
		foreach ($attributes as $key => $value) {
		
			$attribute_pairs[] = "{$key} = '{$value}'";
			
		}
			
		$sql  = "UPDATE " . self::$table_name . " SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= "WHERE entryid=" . $this->entryid;
		
		$database->query($sql);
	
	}
	
	public function updateprofile($fields) {
	
		global $database;
		
		$attributes = $this->sanitized_attributes($fields);
		$attribute_pairs = array();
		
		foreach ($attributes as $key => $value) {
		
			$attribute_pairs[] = "{$key} = '{$value}'";
			
		}
			
		$sql .= "UPDATE " . self::$table_student . " SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= "WHERE studentid=" . $this->studentid;
		
		$database->query($sql);
	
	}

	
}
?>