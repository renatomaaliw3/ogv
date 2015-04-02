<?php

require_once('mysql.php');


class User {

	protected static $table_name="tblstudent";
	protected static $db_fields_student = array('lastname', 'firstname', 'middlename', 'courseid','year','username','passkey');
	protected static $db_fields_user = array('lastname', 'firstname', 'middlename','year','username','passkey');
	
	
	public $studentid;
	public $lastname;
	public $firstname;
	public $middlename;
	public $courseid;
	public $year;
	public $pix;
	public $username;
	public $passkey;

	public static function find_all() {
	
		return self::find_by_sql("SELECT * FROM " . self::$table_name);
	
	}

	public static function find_by_id($studentid=0) {
	
		global $database;
		
		$result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE student_id={$studentid} LIMIT 1");
		
		return !empty($result_array) ? array_shift($result_array) : false;
		
	}
	
	public static function find_by_sql($sql="") {
	
		global $database;
		
		$result_set = $database->query($sql);
		$object_array = array();
		
		while ($record = $database->fetch_array($result_set)) {
			
			$object_array[] = self::instantiate($record);
		
		}
	
		return $object_array;
		
	}
	
	public static function authenticate($username , $passkey ) {
	
		global $database;
		
		$username = $database->mysql_prep($username);
		$password = $database->mysql_prep($passkey);
		
		$sql  = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE username = '{$username}' ";
		$sql .= "AND passkey= '{$password}' ";
		$sql .= "LIMIT 1";
		
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	
	
	}
	
	public function full_name() {
	
		if (isset($this->firstname) && isset($this->lastname)) {
		
			return $this->firstname . " " . $this->lastname;
			
		} else {
		
			return "";
		
		}
	
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
	
	public function save() {
	
		return isset($this->id) ? $this->update() : $this->create();
	
	}
	
	public function createuser($fields) {
	
		global $database; //$database is the instance of the MySQLDatabase class
		
		$attributes = $this->sanitized_attributes($fields);
		
		$sql  = "INSERT INTO " . self::$table_name . " (";
		$sql .= join(",", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		
		$database->query($sql);
	
	}
	
	public function laststudentid() {
	
		global $database; //$database is the instance of the MySQLDatabase class
			
		$sql  = "SELECT studentid FROM tblstudent ORDER BY studentid DESC LIMIT 1";
		$result_set = $database->query($sql);
		
		$row = $database->fetch_array($result_set);
		
		return (array_shift($row));
	
	}
	
	public function updateuser($fields) {
	
		global $database;
		
		$attributes = $this->sanitized_attributes($fields);
		$attribute_pairs = array();
		
		foreach ($attributes as $key => $value) {
			
			$attribute_pairs[] = "{$key} = '{$value}'";
		
		}

		$sql  = "UPDATE " . self::$table_name . " SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE studentid = " . $database->mysql_prep($this->studentid);
		
		$database->query($sql);
	
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function deleterecord($id) {
	
		global $database;
		
		$sql  = "DELETE FROM " . self::$table_name;
		$sql .= " WHERE studentid = " . $id;
		$sql .= " LIMIT 1";
		$database->query($sql);
		
	
	}
	
}

?>