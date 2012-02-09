<?PHP
class misc {
	// PRINT THE CONTENTS OF AN ARRAY OR OBJECT
	static function debug($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
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
	
	// LOAD HEAD ELEMENTS
	static function load_head() {
		global $enable_compression, $_compress, $script_pre, $script_post, $style_pre, $style_post;
		global $_head;
		
		if($enable_compression) {
			$css = $style_pre . CSS ."compress_stylesheets.php" . $style_post . "\n";
			echo $css;
		
			$js = $script_pre . JS . "compress_scripts.php" . $script_post . "\n";
			echo $js;
			
			// LOOP THROUGH HEAD ARRAY AND ADD TO HEAD.JS SCRIPT ACCORDINGLY
			if(count($_head) > 0) {
				// BEGIN HEAD.JS SCRIPT SECTION
				echo "<script type='text/javascript'>\n<!--\n";
				
				// LOAD SCRIPTS
				foreach($_head as $key => $value) {
					echo "head.js(\"$value\");\n";
				}
				
				// CLOSE HEAD.JS SCRIPT SECTION
				echo "// -->\n</script>\n";
			}
		}
		else {
			foreach($_compress['css'] as $key=>$value) {
				echo $style_pre.$value.$style_post."\n";
			}
			
			foreach($_compress['js'] as $key=>$value) {
				echo $script_pre.$value.$script_post."\n";
			}
		}
		
		// SITE FAVICON
		echo FAVICON . "\n" . FAVICON_MOBILE . "\n";
	}
	
	// INCLUDE A CLASS
	static function require_class($classname) {
		$classname = CLASSES."class.".$classname.".php";
		require($classname);
		
		return true;
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
		
		// REMOVE "." AND ".." ENTRIES
		$clean['data'] = array();
		for($i=0;$i<count($data);$i++) {
			if($data[$i] != '.' && $data[$i] != '..') {
				$clean['data'][] = $data[$i];
			}
		}
		
		return $clean['data'];
	}
	
	// LOAD AN XML FILE
	function load_xml($path,$file,$cdata=true) {
		if($cdata) {
			if(!$xml = simplexml_load_file("{$path}{$file}")) {
				// UPDATE LOG
				$this->log .= "Could not read feed file: ".$path.$file." \n";
				$this->write_log($this-log);
				die("Could not read {$file} file");
			}
		}
		else {
			if(!$xml = simplexml_load_file("{$path}{$file}", null, LIBXML_NOCDATA)) {
				// UPDATE LOG
				$this->log .= "Could not read feed file: ".$path.$file." \n";
				$this->write_log($this-log);
				die("Could not read {$file} file");
			}
		}
		
		return $xml;
	}
	
}
?>