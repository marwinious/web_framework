<?PHP
class performance {
	static function cache_load($page) {
		$cacheme = "lib/cache/".$page.".html";
		
		// SERVER FROM CACHE IF NOT EXPIRED
		if(file_exists($cacheme) && (filemtime(BASEPATH.$page.".php") < filemtime(BASEPATH.$cacheme))) {
			include($cacheme);
			// ADD COMMENTED CACHE DATA TO PAGE
			echo "<!-- Cached ".date("H:i",filemtime($cacheme))."-->";
			return true;
			exit;
		}
		
		// CACHED FILE NOT FOUND OR OUT OF DATE, START OUTPUT BUFFER
		performance::start_buffer();
	}
	
	static function cache_save($page) {
		$cacheme = "lib/cache/".$page.".html";
		// OPEN CAHCE FILE FOR WRITING
		$fp = fopen($cacheme, 'w');
		// SAVE THE CONTENTS OF OUTPUT BUFFER TO THE FILE
		fwrite($fp, ob_get_contents());
		// CLOSE THE FILE
		fclose($fp);
		// SEND THE OUTPUT TO THE BROWSER
		performance::stop_buffer();
	}
	
	private function start_buffer() {
		ob_start();
	}
	
	private function stop_buffer() {
		ob_end_flush();
	}
}
?>