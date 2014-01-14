<?PHP
// FILE UPLOADER SCRIPT. DO NOT MODIFY!
// DUPLICATE AND MODIFY AS NEEDED
// MIME TYPES: http://www.webmaster-toolkit.com/mime-types.shtml
// http://reference.sitepoint.com/html/mime-types-full
// http://www.w3schools.com/media/media_mimeref.asp

class uploader {
	function upload($files) {
		// ADD GLOBALS
		global $restricted_file_types;
		global $accepted_file_types;
		global $use_restriction_type;
		global $upload_directory;
		
		// ACQUIRE FILE TYPE
		$file_type = $files["file_upload"]["type"];

		// CHECK FILE TYPE AND THROW ERROR ACCORDINGLY
		switch($use_restriction_type) {
			case "Restricted":
				if(in_array($file_type, $restricted_file_types)) {
					$error_msg = "Invalid file type: $file_type.<br />";
					$error_msg .= "The following file types are not allowed:<br />";
					$error_msg .= "<ul>";
					foreach($restricted_file_types as $key => $value) {
						$error_msg .= "<li>$value</li>";
					}
					$error_msg .= "</ul>";
					die($error_msg);
				}
				break;
			case "Accepted":
				if(!in_array($file_type, $accepted_file_types)) {
					$error_msg = "Invalid file type: $file_type.<br />";
					$error_msg .= "Only the following file types are allowed:<br />";
					$error_msg .= "<ul>";
					foreach($accepted_file_types as $key => $value) {
						$error_msg .= "<li>$value</li>";
					}
					$error_msg .= "</ul>";
					die($error_msg);
				}
				break;
			default:
				break;
		}

		// APPEND DATE/TIME STRING TO FILE NAME IF ALREADY EXISTS
		$file_name = $files["file_upload"]["name"];
		$regex = "/( )/"; // REMOVE SPACES
		$file_name = preg_replace($regex,"_",$file_name); // REPLACE WITH UNDERSCORES
		
		if (file_exists($upload_directory . $file_name)) {
			$now = date("YmdHis");
			$file_name = explode(".",$file_name);
			$file_name[0] .= "_" . $now;
			$file_name = $file_name[0] . "." . end($file_name);
		}

		// MOVE FILE TO UPLOAD DIRECTORY
		move_uploaded_file($files["file_upload"]["tmp_name"],
		$upload_directory . $file_name);
		
		// RETURN FILENAME
		return $file_name;
	}
	
	function import_csv($csv,$table) {
		$this->db = new database();
		$this->db->use_db();
		
		// ADJUST FOR INVALID CHARACTERS IN TABLE NAME
		$regex = "/( )/"; // REMOVE SPACES
		$table = preg_replace($regex,"_",$table); // REPLACE WITH UNDERSCORES
		$regex = "/(\,)/"; // REMOVE COMMAS
		$table = preg_replace($regex,"",$table); // REPLACE WITH NOTHING
	
		$row = 1;
		if(($handle = fopen($csv,"r")) !== FALSE) {
			while(($data = fgetcsv($handle,1000,",")) !== FALSE) {
				// GET COLUMN COUNT
				$num = count($data);
				// GET COLUMN NAMES
				if($row == 1) {
					for($r=0;$r<$num;$r++) {
						$columns[] = $data[$r];
					}
				}
				else {
					for($b=0;$b<$num;$b++) {
						//$column = strtolower($columns[$b]);
						$info[$row][] = $data[$b];
					}
				}
			
				$num = count($data);
				//echo "<p> $num fields in line $row: <br /></p>\n";
				$row++;
				for($c=0;$c<$num;$c++) {
					//echo $data[$c]."<br />\n";
				}
			}
			fclose($handle);
			
			//misc::print_array($info);
			
			// INSERT INTO DATABASE
			$fields = "";
			for($i=0;$i<count($columns);$i++) {
				// ADJUST FOR INVALID CHARACTERS IN COLUMN NAME
				$regex = "/( )/";
				$columns[$i] = preg_replace($regex,"",$columns[$i]);
				$fields .= $columns[$i];
				if(($i+1) != $num) { $fields .= ", "; }
			}
			// CREATE TABLE
			$query = "
			CREATE TABLE $table(
			id INT NOT NULL AUTO_INCREMENT,
			PRIMARY KEY(id)
			";
			foreach($columns as $key=>$value) {				
				$query .= ",$value VARCHAR(255)
				";
			}
			$query .= "
			)
			";
			
			$result = $this->db->query($query);
			
			// INSERT DATA
			for($i=2;$i<$row;$i++) {
				$query = "
				INSERT INTO $table
				($fields)
				VALUES(";
				for($f=0;$f<count($columns);$f++) {
					$query .= "'".$info[$i][$f]."'";
					if($f+1 != $num) { $query .= ", "; }
				}
				$query .= ")";
				
				$result = $this->db->query($query);
			}
		}
		
		//echo "CSV Successfully imported to: $table";
	}
	
	// UPLOADER
	function upload2($files,$destination) {
		// ADD GLOBALS
		global $restricted_file_types;
		global $accepted_file_types;
		global $use_restriction_type;
		global $upload_directory;
	
		// INITIALIZE ERROR TRACKER
		$result = 1;
	
		// LOOP THROUGH FILES AND UPLOAD
		foreach($files as $file) {
			
		   $target_path = $destination . basename($file['name']);

		   if(!move_uploaded_file($file['tmp_name'], $target_path)) {
			  $result = 1;
		   }
		   
		   sleep(1);
		}
		
		return $result;
	}
}
?>