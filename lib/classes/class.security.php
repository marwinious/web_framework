<?PHP
class clean {
	// ESCAPE DANGEROUS CHARACTERS FOR MYSQL
	static function mysql($string) {
		if(version_compare(phpversion(),"4.3.0", "<")) { 
			if(!is_array($string)) {
				$clean = mysql_real_escape_string($string);
			}
			else {
				foreach($string as $key=>$value) {
					// IF A SUB ARRAY IS FOUND, IGNORE IT
					if(!is_array($value)) {
						$clean[$key] = mysql_real_escape_string($value);
					}
				}
			}
		}
		else {
			if(!is_array($string)) {
				$clean = mysql_escape_string($string); 
			}
			else {
				foreach($string as $key=>$value) {
					// IF A SUB ARRAY IS FOUND, IGNORE IT
					if(!is_array($value)) {
						$clean[$key] = mysql_escape_string($value);
					}
				}
			}
		}
		
		return $clean;
	}
	
	static function input($input) {
		if(is_array($input)) {
			$clean = array();
			
			foreach($input as $key=>$value) {
				// IF A SUB ARRAY IS FOUND, IGNORE IT
				if(!is_array($value)) {
					$clean[$key] = trim(htmlentities(stripslashes($value), ENT_QUOTES, "UTF-8"));
				}
			}
		}
		else {
			$clean = trim(htmlentities(stripslashes($input), ENT_QUOTES, "UTF-8"));
		}
		
		return $clean;
	}
	
	static function output($output) {
		if(is_array($output)) {
			$clean = array();
			
			foreach($output as $key=>$value) {
				$clean[$key] = utf8_encode($value);
			}
		}
		else {
			$clean = utf8_encode($output);
		}
		
		return $clean;
	}
	
	static function uncode($string) {
		$string = stripslashes(html_entity_decode($string, ENT_QUOTES, 'UTF-8'));
		return $string;
	}
}

class form_security {
	function load() {
		// ADDING SOME SALT TO THE TOKEN
		$salt = date("YHmsid");
		// INITIALIZE TOKEN
		$token = uniqid(microtime(), true);
		$token .= $salt;
		// ENCRYPT TOKEN
		$token = md5($token);
		// SET SESSION VALUE TO TOKEN FOR LATER COMPARISON
		$_SESSION['security_token'] = $token;
		
		return $_SESSION['security_token'];
	}
	
	function validate($form_token) {
		// CHECK IF SESSION TOKEN IS PRESENT
		if(!isset($_SESSION['security_token'])) {
			return false;
		}
		// CHECK IF FORM TOKEN IS PRESENT
		if(!isset($form_token)) {
			return false;
		}
		// COMPARE BOTH TOKENS TO SEE IF THEY MATCH
		if($_SESSION['security_token'] !== $form_token) {
			return false;
		}
		
		return true;
	}
}
// TO LOAD FORM SECURITY, COPY THE CODE BELOW TO FORM PAGE
/*
$formsec = new form_security();
$token = $formsec->load();
*/

// TO LOAD FROM VALIDATION, COPY THE CODE BELOW TO THE PROCESSOR PAGE
/*
$formsec = new form_security();
if(!$formsec->validate($security_token)) {
	misc::write_log("Possible hack attempt");
	header("Location: ../../error.php");
	die();
}
*/
?>