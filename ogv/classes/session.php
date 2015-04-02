<?php 
	
class Session {
	
	public $logged_in = false;
	public $studentid;
	
	function __construct() {
		
		session_start();
		$this->check_login();
		
	}
	
	public function is_logged_in() {
	
		return $this->logged_in;
	
	}
	
	public function login($user) {
	
		if ($user) {
		
			$this->studentid = $_SESSION['studentid'] = $user->studentid;
			$this->logged_in = true;
		
		} else {
		
		
		}
	
	}
	
	public function logout() {
	
		unset($_SESSION['studentid']);
		unset($this->studentid);
		$this->logged_in = false;
	
	
	}
	
	private function check_login() {
	
		if (isset($_SESSION['studentid'])) {
		
			$this->studentid = $_SESSION['studentid'];
			$this->logged_in = true;
		
		} else {
		
			unset($this->studentid);
			$this->logged_in = false;
		
		}
	
	}
	
	public function set_encripted_number($controlnum) {
	
		self::$thecontrolnum = $_SESSION['controlnum'] = $controlnum;
	
	}

		
}
	
$session = new Session();
?>