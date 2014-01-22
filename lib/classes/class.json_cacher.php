<?PHP
/*
SCRIPT: JSON CACHER
AUTHOR: DARIUS BABCOCK
DESCRIPTION: Caches JSON content to local files. Serves cached files unless they are older than $max_cache_lifetime
LAST UPDATED: 1/13/2014
*/
class json_cacher {
	
	var $json;
	var $json_url;
	var $filename;
	var $max_cache_lifetime;
	var $force_reload;
	var $format;
	
	// INIT
	function __construct($filename, $json_url, $max_cache_lifetime=15, $force_reload = 'false', $save_path = '', $format='json') {
		// INIT VARIABLES
		$this->filename = $filename;
		$this->json_url = $json_url;
		$this->force_reload = $force_reload;
		$this->max_cache_lifetime = $max_cache_lifetime; // IN MINUTES
		$this->save_path = $save_path;
		$this->format = $format;
	}
	
	// GET JSON CONTENTS FROM URL
	function get_json() {
		switch(strToLower($this->format)) {
			case 'xml': case 'rss':
				$this->json = $this->get_xml_json($this->json_url);
				break;
				
			case 'json':
				$this->json = file_get_contents($this->json_url);
				break;
		}
		
		return true;
	}
	
	// GET XML CONTENTS FROM URL AND CONVERT TO JSON
	function get_xml_json($url) {
		$fileContents= file_get_contents($url);
		$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
		$fileContents = trim(str_replace('"', "'", $fileContents));
		$simpleXml = simplexml_load_string($fileContents);
		$json = json_encode($simpleXml);

		return $json;
	}
	
	// SAVE JSON TO A LOCAL FILE
	function cache_json() {	
		// GET JSON
		$this->get_json();
		
		// DETERMINE FILENAME FOR CACHING
		$cache_file = $this->clean_filename($this->filename.'.cache');
		
		// DECODE JSON TO OBJECT FOR EDITING
		$temp_json = $this->json;
		$temp_json = json_decode($temp_json);
		// CHECK IF GOOGLE SPREADSHEET
		$is_gs = false;
		if(isset($temp_json->feed->entry)) {
			$is_gs = true;
		}
		// ENCODE OBJECT BACK TO JSON AND SAVE
		$this->json = json_encode($temp_json);
		
		// GATHER ANY SUB-FEEDS
		if($is_gs) {
			$this->load_sub_feeds();
		}
		
		// OPEN CACHE FILE FOR WRITING, SAVE, AND CLOSE
		$full_path = $this->save_path.$cache_file;
		if($fh = fopen($full_path, 'w')) {
			//echo "Successully opened file '{$cache_file}' for editing!<br />";
			fwrite($fh, $this->json);
			fclose($fh);
		}
		else {
			//echo "Could not open/create file: '{$cache_file}' for editing.";
		}
		
		
		return true;
	}
	
	// CLEAN UP THE CACHE FILENAME PER STANDARDS
	function clean_filename($filename) {
		$filename = strtolower(str_replace(' ','_',$filename));
		
		return $filename;
	}
	
	// RETRIEVE CACHED CONTENT FROM CACHE FILE
	function load_cache() {
		$filename_full = $this->save_path.$this->filename.'.cache';
	
		if(file_exists($filename_full)) {
			// GET REQUESTED CACHE FILE
			$cache = file_get_contents($filename_full);
		
			// IF CACHE FILE IS OLDER THAN MAX_CACHE_LIFETIME, RELOAD ORIGINAL SOURCE
			if(floor((strtotime(date('Y-m-d H:i:s')) - filemtime($filename_full))/(60)) >= $this->max_cache_lifetime || $this->force_reload == 'true') {
				// REFRESH CACHE CONTENTS WITH LATEST DATA
				$this->cache_json();
				
				// RELOAD CACHE FROM FILE
				$cache = file_get_contents($filename_full);
			}
		}
		else {
			// REFRESH CACHE CONTENTS WITH LATEST DATA
			$this->cache_json();
			
			// RELOAD CACHE FROM FILE
			$cache = file_get_contents($filename_full);
		}

		// OUTPUT JSON
		echo $cache;
	}
	
	// LOAD SUB-FEEDS FROM GOOGLE SPREADSHEET
	function load_sub_feeds() {
		// DECODE JSON TO OBJECT FOR EDITING
		$temp_json = $this->json;
		$temp_json = json_decode($temp_json);
		
		// DEFINE SPECIAL VARS
		$content_attr = 'gsx$content';
		$content_attr_t = '$t';
		
		// LOOP THROUGH EACH ROW AND LOOK FOR SPECIAL FLAGS
		for($i=0;$i<count($temp_json->feed->entry);$i++) {
			// GET ROW CONTENT
			$content = $temp_json->feed->entry[$i]->$content_attr->$content_attr_t;
			
			// CHECK FOR FLAG
			if(substr($content,0,1) == '!') {
				// REMOVE FLAG
				$content = str_replace('!','',$content);
				
				// SPLIT MEDLEY OBJECT INFO INTO ARRAY
				$medleyObject = explode('-',$content);
				
				// CREATE MEDLEY URL
				$medleyObjectURL = 'http://host.coxmediagroup.com/cop/digital/common/cache/cacher.php?saveas='.$content.'&json_url=http%3A%2F%2Fwww.whio.com%2Fapi%2Fcontent%2Fv1%2F'.$medleyObject[0].'%2F'.$medleyObject[1].'%2F%3Fformat%3Djson';
				
				// MODIFY CONTENT BASED ON OBJECT TYPE
				switch($medleyObject[0]) {
					case 'manuallist':
						// GET MEDLEY FEED
						$fromMedley = json_decode(file_get_contents($medleyObjectURL));
						
						// CREATE UL
						$list = $this->create_list('ul',$fromMedley->objects,5);
						
						// USE UL AS NEW CONTENT
						$temp_json->feed->entry[$i]->$content_attr->$content_attr_t = $list;
						
						break;
						
					case 'automaticlist':
						// GET MEDLEY FEED
						$fromMedley = json_decode(file_get_contents($medleyObjectURL));
						
						// CREATE UL
						$list = $this->create_list('ul',$fromMedley->objects,5);
						
						// USE UL AS NEW CONTENT
						$temp_json->feed->entry[$i]->$content_attr->$content_attr_t = $list;
						
						break;
				}
			}
		}
		
		// RE-ENCODE JSON AND SAVE
		$this->json = json_encode($temp_json);
		
		return true;
	}
	
	// CREATE A LIST FROM MEDLEY FEED
	function create_list($list_type,$source,$item_count=5) {
		// INIT LIST
		$list = "<{$list_type}>";
		
		// POPULATE LIST
		for($i=0;$i<$item_count;$i++) {
			$list .= '<li>'.$source[$i]->title.'</li>';
		}
		
		// CLOSE LIST
		$list .= "</{$list_type}>";
		
		return $list;
	}
}

?>