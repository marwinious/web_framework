<?PHP
class email {
	
	// INITIALIZE VARIABLES
	var $to = array();
	var $cc = array();
	var $from = 'no-reply@emailscript.com';
	var $subject = 'Sample subject';
	var $body = 'Sample body';
	var $attachments = array();
	var $headers = '';
	
	// OPTIONALLY DEFINE PRIMARY PARAMETERS ON CONSTRUCT
	function __construct($to = '',$from = '',$subject = '', $body = '') {
		if(!empty($to)) { $this->to[] = $to; }
		if(!empty($from)) { $this->from = $from; }
		if(!empty($subject)) { $this->subject = $subject; }
		if(!empty($body)) { $this->body = $body; }
	}
	
	// ADD A "TO" PARAMETER
	function addTo($email) {
		$this->to[] = $email;
	}
	
	// ADD A "CC" PARAMETER
	function addCC($email) {
		$this->cc[] = $email;
	}
	
	// SET "FROM" PARAMETER
	function from($email) {
		$this->from = $email;
	}
	
	// SET "SUBJECT" PARAMETER
	function subject($subject) {
		$this->subject = $subject;
	}
	
	// SET "BODY" PARAMETER
	function body($body) {
		$this->body = $body;
	}
	
	// ADD AN "ATTACHMENT" FILE
	function addAttachment($file_path) {
		$this->attachments[] = $file_path;
	}
	
	// SEND EMAIL
	function send() {
		// CLEAN ARRAYS
		$this->to = $this->clean_array($this->to);
		$this->cc = $this->clean_array($this->cc);
	
		// SETUP HEADERS
		$this->create_headers();
		
		// EMAIL AND RETURN RESULT
		return mail($this->to, $this->subject, $this->body, $this->headers); 
	}
	
	// CREATE HEADER DATA
	function create_headers() {
		// INIT
		$body_text = strip_tags($this->body);
		$body_html = $this->body;
		
		// CREATE PRIMARY BOUNDARY
		$primary_boundary = md5(date('r', time()));
		
		// BEGIN PRIMARY CONTENT TYPE
		$this->headers = "Content-Type: multipart/mixed;".PHP_EOL;
		$this->headers .= " boundary=\"_{$primary_boundary}_\"".PHP_EOL;
		
		// SET FROM, CC AND SUBJECT
		$this->headers .= "From: <{$this->from}>".PHP_EOL;
		if(!empty($this->cc)) {
			$this->headers .= "CC: {$this->cc}".PHP_EOL;
		}
		$this->headers .= "Subject: {$this->subject}".PHP_EOL;
		$this->headers .= "Message-ID: <".time()."-".$this->from['email'].">".PHP_EOL;
		$this->headers .= "X-Mailer: PHP v".phpversion().PHP_EOL; 
		
		// SET MIME-VERSION
		$this->headers .= "MIME-Version: 1.0".PHP_EOL;
		$this->headers .= PHP_EOL.PHP_EOL;
		// CLOSE FIRST SECTION OF PRIMARY BOUNDARY
		$this->headers .= "--_{$primary_boundary}_".PHP_EOL;
		
		// CREATE ALT BOUNDARY
		$alt_boundary = md5(date('r', time()));
		$this->headers .= "Content-Type: multipart/alternative;".PHP_EOL;
		$this->headers .= " boundary=\"_{$alt_boundary}_\"".PHP_EOL;
		$this->headers .= PHP_EOL.PHP_EOL;
		$this->headers .= "--_{$alt_boundary}_".PHP_EOL;
		
		// CREATE PLAIN TEXT VERSION OF MESSAGE BODY
		$this->headers .= "Content-Type: text/plain; charset=\"UTF-8\"".PHP_EOL;
		$this->headers .= "Content-Transfer-Encoding: 8bit".PHP_EOL;
		$this->headers .= PHP_EOL.PHP_EOL;
		$this->headers .= $body_text.PHP_EOL;
		$this->headers .= PHP_EOL;
		$this->headers .= "--_{$alt_boundary}_".PHP_EOL;
		
		// CREATE HTML VERSION OF MESSAGE BODY
		$this->headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".PHP_EOL;
		$this->headers .= "Content-Transfer-Encoding: 7bit".PHP_EOL;
		$this->headers .= PHP_EOL;
		$this->headers .= PHP_EOL;
		$this->headers .= "<html><head></head><body>{$body_html}</body></html>".PHP_EOL;
		$this->headers .= PHP_EOL;
		$this->headers .= "--_{$alt_boundary}_".PHP_EOL;
		$this->headers .= PHP_EOL;
		$this->headers .= "--_{$primary_boundary}_".PHP_EOL;
		
		// PROCESS ATTACHMENTS
		$this->process_attachments($primary_boundary);
		
		// CLOSE PRIMARY BOUNDARY
		$this->headers .= "--_{$primary_boundary}_--".PHP_EOL;
	}
	
	// PROCESS EMAIL ATTACHMENTS
	function process_attachments($primary_boundary) {
		if(count($this->attachments) > 0) {
			foreach($this->attachments as $file) {
				// GET FILE MIME TYPE
				$mimetype = mime_content_type($file);
				// GET FILENAME
				$filename = explode('/',$file);
				$filename = end($filename);
				// ENCODE FILE TO BASE64
				$file_64 = chunk_split(base64_encode(file_get_contents($file)));
				
				// ADD HEADERS
				$this->headers .= "Content-Type: {$mimetype}".PHP_EOL;
				$this->headers .= "Content-Transfer-Encoding: base64".PHP_EOL;
				$this->headers .= "Content-Disposition: attachment; filename=\"{$filename}\"".PHP_EOL;
				$this->headers .= PHP_EOL;
				$this->headers .= $file_64.PHP_EOL;
				$this->headers .= "--_{$primary_boundary}_".PHP_EOL;
			}
		}
		
		return true;
	}
	
	// TRANSLATE EMAIL ARRAY TO DELIMITED STRING
	function clean_array($array) {
		// CHECK THAT ARRAY IS ACTUALLY AN ARRAY AND NOT EMPTY
		if(is_array($array) && count($array) > 0) {
			// INIT STRING
			$clean = '';
			
			// LOOP THROUGH ELEMENTS
			for($i=0;$i<count($array);$i++) {
				$clean .= $array[$i];
				
				if($i != (count($array)-1)) {
					$clean .= ",";
				}
			}
			
			// RETURN STRING
			return $clean;
		}
		
		return false;
	}
}
?>