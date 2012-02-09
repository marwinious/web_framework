<?PHP
class email {
	
	// INITIALIZE VARIABLES
	function __construct() {
		$this->to = '';
		$this->cc = '';
		$this->from = '';
		$this->subject = '';
		$this->body = '';
		$this->attachment_path = '';
	}
	
	// SET "TO"
	function to($to) {
		$this->to = $to;
	}
	
	// SET "CC"
	function cc($cc) {
		$this->cc = $cc;
	}
	
	// SET "FROM"
	function from($from) {
		$this->from = $from;
	}
	
	// SET "SUBJECT"
	function subject($subject) {
		$this->subject = $subject;
	}
	
	// SET "BODY"
	function body($body) {
		$this->body = $body;
	}
	
	// SET "ATTACHMENT_PATH"
	function attachment_path($attachment_path) {
		$this->attachment_path = $attachment_path;
	}
	
	// SEND EMAIL
	function send($type="PLAIN TEXT") {
		if(!empty($this->attachment_path)) {
			$file = $this->attachment_path;
			$file_size = filesize($file);
			$handle = fopen($file, "r");
			$content = fread($handle, $file_size);
			fclose($handle);
			$content = chunk_split(base64_encode($content));
			$uid = md5(uniqid(time()));
			$name = basename($file);
			$header = "From: $from \r\n";
			if(!empty($this->cc)) { $header .= "CC: {$this->cc} \r\n"; }
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
		}
		else {
			if($type == "HTML") {
				$header = "MIME-Version: 1.0" . "\r\n";
				$header .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$header .= "From: ".$this->from." \r\n";
			}
			else {
				$header = "From: ".$this->from." \r\n";
			}

			if(!empty($this->cc)) { $header .= "CC: {$this->cc} \r\n"; }
		}
		
		if (mail($this->to, $this->subject, $this->body, $header)) { return true; } 
		else { return false; }
	}
}
?>