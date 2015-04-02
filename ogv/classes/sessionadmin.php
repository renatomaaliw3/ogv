<?php 
	
class SessionAdmin {
	
	public $logged_in = false;
	public $userid;
	
	function __construct() {
		
		session_start();
		$this->check_login();
		
	}
	
	public function is_logged_in() {
	
		return $this->logged_in;
	
	}
	
	public function login($user) {
	
		if ($user) {
		
			$this->userid = $_SESSION['userid'] = $user->userid;
			$this->logged_in = true;
		
		} else {
		
		
		}
	
	}
	
	public function logout() {
	
		unset($_SESSION['userid']);
		unset($this->userid);
		$this->logged_in = false;
	
	
	}
	
	private function check_login() {
	
		if (isset($_SESSION['userid'])) {
		
			$this->userid = $_SESSION['userid'];
			$this->logged_in = true;
		
		} else {
		
			unset($this->userid);
			$this->logged_in = false;
		
		}
	
	}
			
}
	
$sessionadmin = new SessionAdmin();
?>