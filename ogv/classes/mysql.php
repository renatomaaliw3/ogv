<?php
	
require_once("config.php"); //these are the database configuration

class MySQLDatabase	{

	public $connection;
	private $magic_quotes_active;
	private $new_enough_php;
	
	function __construct() {

		$this->open_connection();	//open connection to database	
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->new_enough_php = function_exists("mysql_real_escape_string");
				
	}
	
	public function open_connection() {
		
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS); //connect to database using the parameters
		
		if (!$this->connection) {
		
			die("Database connection failed: " . mysql_error());
		
		} else {
		
			$db_select = mysql_select_db(DB_NAME, $this->connection); //select the database name
			
			if (!$db_select) {
			
				die("Database selection failed: " . mysql_error());
			
			}
			
		}
	}
	
	public function close_connection() { //close database connection
	
		if (isset($this->connection)) {
		
			mysql_close($this->connection);
			unset($this->connection);
		
		}
	
	}
	
	public function query($sql) { //execute queries
	
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		
		return $result;
	}
	
	public function mysql_prep($value) { //prepare values for SQL INSERT
			
		if ($this->new_enough_php) {
		
			if($this->magic_quotes_active) {
			
				$value = stripslashes($value);
				$value = mysql_real_escape_string($value);
			
			} else {
			
				if (!$this->magic_quotes_active) {
				
					$value = addslashes($value);
				
				}
			
			}
		
		}
	
		return $value;
	}
	
	public function fetch_array($result_set) { //perform fetch array base on sql queries
	
		return mysql_fetch_array($result_set);
	
	}
	
	public function num_rows($result_set) { //count the number of rows return base on sql queries
	
		return mysql_num_rows($result_set);
	
	}
	
	public function affected_rows() {
	
		return mysql_affected_rows($this->connection);
		
	}


	private function confirm_query($result) { //confirm if query syntax is correct
	
		if (!$result) {
			
			die("Database query failed: " . mysql_error());
		
		}
	
	}
		
} 

$database = new MySQLDatabase();

?>