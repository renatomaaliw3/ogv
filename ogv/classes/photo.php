<?php

require_once('mysql.php'); 
	
class Photo extends MySQLDatabase {
	
	protected static $table_name="tblstudent";
	
	public $studentid;
	
	public $filename;
	public $type;
	public $size;
	
	private $temp_path;
	protected $upload_dir="profilepics/";
	public $errors = array();
	
	protected $upload_errors = array(
	
	UPLOAD_ERR_OK => "No errors",
	UPLOAD_ERR_INT_SIZE => "Larger than upload_max_filesize",
	UPLOAD_ERR_FORM_SIZE => "Larger than form MAX_FILE_SIZE.",
	UPLOAD_ERR_PARTIAL => "Partial upload.",
	UPLOAD_ERR_NO_FILE => "No file",
	UPLOAD_ERR_NO_TMP_DIR => "No temporary directory",
	UPLOAD_ERR_CANT_WRITE => "Can't write to disk",
	UPLOAD_ERR_EXTENSION => "File upload stopped by extension"
	
	);
	
	public function attach_file($file) {
	
		if (!$file || empty($file) || !is_array($file)) {
		
			$this->errors[] = "No file was uploaded.";
			
			return false;
			
		} else if ($file['error'] != 0) {
		
			$this->errors[] = $this->upload_errors[$file['error']];
			return false;
		
		} else {
	
			$this->temp_path = $file['tmp_name'];
			$this->filename = basename($file['name']);
			$this->type = $file['type'];				
			$this->size = $file['size'];		
			return true;
		
		}
	
	}
	
	public function previousphoto() {
	
		$sql = "SELECT pix FROM tblstudent WHERE studentid = " . $this->studentid . " LIMIT 1";
		$result_set = parent::query($sql);
		$row = parent::fetch_array($result_set);
		
		return array_shift($row);
	
	}
	
	public function savephoto() {
	
		if (!empty($this->errors)) {
		
			return false;
		
		}
		
		if (empty($this->filename) || empty($this->temp_path)) {
		
			$this->errors[] = "The file location was not available";
			return false;
			
		}
		
		$target_path = $this->upload_dir . $this->filename;
		$thephoto = $this->previousphoto();
		
		if (empty($thephoto)) {
		
			if (move_uploaded_file($this->temp_path, $target_path)) {
		
				//Success				
				$this->updatestudentpix();
				unset($this->temp_path);
			
	
			} else {
		
				$this->errors[] = "The file failed to upload possibly due to folder permissions!";
		
			}
			
			
		} else {
		
			if (!file_exists($this->upload_dir . $thephoto)) {
			
				move_uploaded_file($this->temp_path, $target_path);
		
				//Success				
				$this->updatestudentpix();
				unset($this->temp_path);
			
			} else {
			
				unlink($this->upload_dir . $thephoto);
				move_uploaded_file($this->temp_path, $target_path);				
				$this->updatestudentpix();
				unset($this->temp_path);
					
			}
				
		}
				
	}
	
	private function updatestudentpix() {
	
		$sql  = "UPDATE tblstudent SET pix = " . "'" . $this->filename . "'";
		$sql .= " WHERE studentid = " . $this->studentid;
		
		parent::query($sql);
			
	}
}	
?>