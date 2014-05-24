<?PHP
class misc {
	// PRINT THE CONTENTS OF AN ARRAY/OBJECT
	static function debug($data) {
		echo "<pre>";print_r($data);echo "</pre>";
	}

	// WRITE INFORMATION TO LOG FILE (LIB/PHP/LOG.TXT). EXPECTS $TITLE
	static function write_log($title) {
		// GET REMOTE IP
		$ip = $_SERVER['REMOTE_ADDR'];
		// GET HOST FROM IP
		$host = gethostbyaddr($ip);
		// SET DATE/TIME
		$date = date("m/d/Y H:ia");
		// LOG FILE LOCATION
		$log_file = "log.txt";
		
		// LOG ENTRY TEXT
		$log = "$date - $title\r\n";
		$log .= "Remote IP: $ip\r\n";
		$log .= "Host: $host\r\n";
		$log .= "\r\n";
		
		// INSERT LOG ENTRY
		$file = fopen($log_file, 'a');
		fputs($file, $log);
		fclose($file);
	}
	
	// CHECK FOR MOBILE BROWSER
	static function check_mobile() {
		$mobile_browser = '0';
		 
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
		}
		 
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
		}    
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');
		 
		if (in_array($mobile_ua,$mobile_agents)) {
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
			$mobile_browser = 0;
		}
		 
		if ($mobile_browser > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	// GET DIRECTORY FILE LIST
	static function scan_dir($dir) {	
		// SCAN DIRECTORY
		if(!$data = scandir($dir)) {
			return false;
		}
		
		// REMOVE ".","..",".HTACCESS" ENTRIES
		$clean['data'] = array();
		for($i=0;$i<count($data);$i++) {
			if($data[$i] != '.' && $data[$i] != '..' && $data[$i] != '.htaccess') {
				$clean['data'][] = $data[$i];
			}
		}
		
		return $clean['data'];
	}

	// GET TEMPLATE AND OPTIONALLY REPLACE PLACEHOLDERS
	// EXPECTS "$REPLACEMENTS" TO BE "FIND" => "REPLACE" ASSOCIATIVE ARRAY
	static function buffer_template($templatePath, $replacements='') {
		// START OUTPUT BUFFER
		ob_start();

		// GET TEMPLATE CONTENTS
		include($templatePath);

		// SAVE BUFFER TO VARIABLE
		$buffer = ob_get_clean();

		// REPLACE PLACEHOLDERS
		if($replacements && is_array($replacements)) {
			$buffer = str_replace(array_keys($replacements), array_values($replacements), $buffer);
		}

		// OUTPUT BUFFER
		return $buffer;
	}
	
}
?>