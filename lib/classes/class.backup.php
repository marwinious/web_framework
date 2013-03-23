<?PHP
include_once('class.ftp.php');

class backup {
	private $db;
	
	// INIT
	function __construct() {
		$this->db = new mysql();
	}
	
	// BACKUP A MYSQL DATABASE
	function backup_mysql($tables = '*') {
		GLOBAL $backup_dir;
		GLOBAL $backup_ftp_enable;
		GLOBAL $backup_ftp_remote_dir;
		GLOBAL $backup_ftp_server;
		GLOBAL $backup_ftp_username;
		GLOBAL $backup_ftp_password;
		GLOBAL $backup_ftp_port;
		GLOBAL $backup_email_enable;
		GLOBAL $backup_email_to;
		GLOBAL $backup_email_from;
		GLOBAL $backup_email_subject;
		
		$return = "";
		
		// GET TABLE NAMES
		if($tables == '*') {
			// GET ALL TABLE NAMES
			$tables = array();
			$sql = "
			SHOW TABLES
			";
			
			$result = $this->db->query($sql,false);
			while($row = mysql_fetch_row($result)) {
				$tables[] = $row[0];
			}
		}
		else {
			// GET SELECTED TABLE NAMES
			if(!is_array($tables)) {
				$tables = explode(',',$tables);
			}
		}
		
		// LOOP THROUGH EACH TABLE
		foreach($tables as $table) {
			// GET ALL TABLE DATA
			$sql = "
			SELECT *
			FROM {$table}
			";
			
			$result = $this->db->query($sql,false);
			$num_fields = mysql_num_fields($result);
			
			// ADD "DROP TABLE" PARAM TO BACKUP FILE (ONLY APPLIES ON RESTORING DB)
			$return .= 'DROP TABLE IF EXISTS '.$table.';';
			
			// GET THE "CREATE TABLE" QUERY
			$sql = "
			SHOW CREATE TABLE {$table}
			";
			$row2 = mysql_fetch_row($this->db->query($sql,false));
			$return .= "\n\n".$row2[1].";\n\n";
			
			// LOOP THROUGH TABLE FIELDS/COLUMNS
			for ($i=0;$i<$num_fields;$i++) {
				while($row = mysql_fetch_row($result)) {
					$return .= 'INSERT INTO '.$table.' VALUES(';
					for($j=0;$j<$num_fields;$j++) {
						$row[$j] = addslashes($row[$j]);
						$row[$j] = str_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return .= '"'.$row[$j].'"' ; } else { $return .= '""'; }
						if ($j<($num_fields-1)) { $return .= ','; }
					}
					$return .= ");\n";
				}
			}
			$return .= "\n\n\n";
		}
		
		// EXPORT BACKUP AS A FILE
		$filename = 'db-backup-'.date("Ymd-His").'-'.(md5(implode(',',$tables))).'.sql';
		$handle = fopen($backup_dir.$filename,'w+');
		fwrite($handle,$return);
		fclose($handle);
		
		// IF FTP ENABLED, FTP OUT BACKUP FILE
		if($backup_ftp_enable == true) {
			$this->ftp_backup($backup_ftp_server, $backup_ftp_username, $backup_ftp_password, $backup_ftp_port, $backup_ftp_remote_dir, $backup_dir, $filename);
		}
		
		// IF EMAIL ENABLED, EMAIL OUT BACKUP FILE
		if($backup_email_enable == true) {
			$this->email_backup($backup_email_to, $backup_email_from, $backup_email_subject, $backup_dir, $filename);
		}
		
		return true;
	}
	
	// EMAIL THE BACKUP FILE
	function email_backup($to, $from, $subject, $backup_dir, $filename) {
		$file = $backup_dir.$filename;
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$name = basename($file);
		$header = "From: $from \r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
		$header .= "Content-Transfer-Encoding: base64\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$header .= $content."\r\n\r\n";
		$header .= "--".$uid."--";
		if (mail($to, $subject, "", $header)) {
			return true;
		}
		else {
			return false;
		}
		
	}
	
	// FTP THE BACKUP FILE
	function ftp_backup($server, $username, $password, $port, $remote_dir, $backup_dir, $filename) {
		$ftp = new ftp($server, $username, $password, $port);
		$ftp->connect();
		$ftp->chdir($remote_dir);
		$ftp->upload($backup_dir.$filename,$filename);
		$ftp->close();
	}
}
?>