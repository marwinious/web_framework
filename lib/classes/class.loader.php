<?PHP
class loader {
	// LOAD HEAD ELEMENTS
	static function load_head() {
		global $enable;
		global $_head, $_jquery, $_js, $_960, $_load, $_stylesheet;
		
		// CHECK ENABLED ARRAY AND ONLY LOOK AT ENABLED ITEMS
		$enabled = array();
		foreach($enable as $key=>$value) {
			if($value) { $enabled[$key] = true; }
		}
		
		// LOAD ENABLED ELEMENTS
		$elements = array();
		foreach($enabled as $key=>$value) {
			if(isset($_load[$key])) {
				$elements[] = loader::load_elements($_load[$key]);
			}
		}
		
		// CLEAN UP ARRAYS
		$js = array();
		$css = array();
		foreach($elements as $element) {
			if(is_array($element['js']) && !empty($element['js'])) {
				foreach($element['js'] as $script) {
					$js[] = $script;
				}
			}
			if(is_array($element['css']) && !empty($element['css'])) {
				foreach($element['css'] as $style) {
					$css[] = $style;
				}
			}
		}
		
		// AUTO-LOAD STYLESHEETS
		$autocss = misc::scan_dir(CSS.'autoload/');
		foreach($autocss as $file) {
			// GET FILE EXTENSION AND TEST
			$info = pathinfo(CSS.'autoload/'.$file);
			if($info['extension'] == 'css' || $info['extension'] == 'php') {
				$css[] = CSS.'autoload/'.$file;
			}
		}
		
		// AUTO-LOAD JAVASCRIPT
		$autojs = misc::scan_dir(JS.'autoload/');
		foreach($autojs as $file) {
			// GET FILE EXTENSION AND TEST
			$info = pathinfo(CSS.'autoload/'.$file);
			if($info['extension'] == 'js') {
				$js[] = JS.'autoload/'.$file;
			}
		}
		
		// LOAD CORE STYLESHEETS
		if($enable['core']) {
			$corecss = $_stylesheet['core'];
			foreach($corecss as $core) {
				$css[] = $core;
			}
		}
		
		$elements = array();
		$elements['js'] = $js;
		$elements['css'] = $css;
		
		// SITE FAVICON
		echo FAVICON . "\n" . FAVICON_MOBILE . "\n";
		
		if($enable['compression']) {	
			// LOAD CSS
			echo "<link rel='stylesheet' type='text/css' href='".CSS."compress_stylesheets.php' />\n";
			
			// LOAD JS
			echo "<script type='text/javascript' src='".JS."compress_scripts.php'></script>\n";
			
			return $elements;
		}
		else {
			// LOAD CSS
			foreach($elements['css'] as $element) {
				echo "<link rel='stylesheet' type='text/css' href='{$element}' />\n";
			}
			
			// LOAD JS
			foreach($elements['js'] as $element) {
				echo "<script type='text/javascript' src='{$element}'></script>\n";
			}
			
			return true;
		}
	}
	
	// LOAD NEEDED ELEMENTS FOR HEAD
		static function load_elements($series) {
			global $_load;
			
			$js = array();
			$css = array();
			$data = array();
			
			// VERIFY THAT THE ELEMENT EXISTS
			if(isset($series)) {
				// LOOP THROUGH ITEMS OF ELEMENT
				if(is_array($series)) {
					foreach($series as $element=>$path) {
						// IF THE CURRENT ITEM IS NOT AN ARRAY, LOAD IT
						if(!is_array($path)) {
							$parts = explode('.',$path);
							// CHECK IF JS FILE
							if(end($parts) == 'js') {
								//echo "<script type='text/javascript' src='{$path}'></script>\n";
								$js[] = $path;
							}
							// CHECK IF CSS FILE
							else if(end($parts) == 'css') {
								//echo "<link rel='stylsheet' type='text/css' href='{$path}' />\n";
								$css[] = $path;
							}
						}
					}
				}
				else {
					$parts = explode('.',$series);
					// CHECK IF JS FILE
					if(end($parts) == 'js') {
						//echo "<script type='text/javascript' src='{$series}'></script>\n";
						$js[] = $series;
					}
					// CHECK IF CSS FILE
					else if(end($parts) == 'css') {
						//echo "<link rel='stylsheet' type='text/css' href='{$series}' />\n";
						$css[] = $series;
					}
				}
			}
			
			$data['js'] = $js;
			$data['css'] = $css;
			
			return $data;
		}
	
	// LOAD METADATA
	static function load_meta() {
		GLOBAL $_metadata, $_expires;
		
		// LOAD META DATA
		foreach($_metadata as $key=>$value) {
			echo "{$value}\n";
		}
		
		// LOAD EXPIRES TAG
		if(isset($_expires) && !empty($_expires)) {
			// GET FILENAME
			$filename = FILENAME;
			
			// CHECK IF FILE EXISTS
			if(file_exists($filename)) {
				// BUILD EXPIRATION FROM FILE MOD TIME
				$mtime = date('Y-m-d H:i:s',filemtime($filename));
				$date = date($_expires['format'],strtotime($mtime.$_expires['offset']));
			}
			else {
				// BUILD EXPIRATION FROM TODAY'S DATE
				$date = date($_expires['format'],strtotime($_expires['default'].$_expires['offset']));
			}
			
			// BUILD EXPIRATION META TAG
			$meta_expire = str_replace('#EXPIRES#',$date,$_expires['template']);
			
			echo "{$meta_expire}\n";
		}
	}
	
	// LOAD A FILE
	static function load_file($classname,$level='require',$path='',$prefix='class.',$ext='php') {
		// CHECK FOR PATH ALTERNATIVE
		if(empty($path)) {
			// LOAD CLASS VIA CHOSEN METHOD WITH FIXED PATH
			$level = strtoupper($level);
			if($level == "REQUIRE") { require(CLASSES.$prefix.$classname.'.'.$ext); }
			else if($level == "INCLUDE") { include(CLASSES.$prefix.$classname.'.'.$ext); }
		}
		else {
			// LOAD CLASS VIA CHOSEN METHOD WITH CUSTOM PATH
			$level = strtoupper($level);
			if($level == "REQUIRE") { require($path.$prefix.$classname.'.'.$ext); }
			else if($level == "INCLUDE") { include($path.$prefix.$classname.'.'.$ext); }
		}
		
		return true;
	}
	
	// AUTO-LOAD FILE(S)
	static function auto_load($path,$level='require') {
		// AUTO LOAD CLASSES FROM CUSTOM PATH
		$level = strtoupper($level);
		
		// FIND FILES AND LOOP
		if($files = misc::scan_dir($path)) {
			foreach($files as $file) {
				if($level == "REQUIRE") { require($path.$file); }
				if($level == "INCLUDE") { include($path.$file); }
			}
		}
		
		return true;
	}
	
	// LOAD AN XML FILE
	static function load_xml($path,$file,$cdata=true) {
		if($cdata) {
			if(!$xml = simplexml_load_file("{$path}{$file}")) {
				die("Could not read {$file} file");
			}
		}
		else {
			if(!$xml = simplexml_load_file("{$path}{$file}", null, LIBXML_NOCDATA)) {
				die("Could not read {$file} file");
			}
		}
		
		return $xml;
	}
	
	// LOAD CKEDITOR
	static function load_ckeditor() {
		GLOBAL $enable,$script_pre,$script_post;
		
		if($enable['ckeditor']) {
			echo $script_pre.LIB."ckeditor/ckeditor.js".$script_post;
		}
	}
	
	// LOAD A FONT
	static function load_webfont($family,$filename,$path) {
		$data = "@font-face {"."\n";
		$data .= "font-family: '{$family}';"."\n";
		$data .= "src: url('{$path}{$filename}.eot');"."\n";
		$data .= "src: url('{$path}{$filename}.eot?iefix') format('embedded-opentype'),"."\n";
		$data .= "url('{$path}{$filename}.woff') format('woff'),"."\n";
		$data .= "url('{$path}{$filename}.ttf') format('truetype'),"."\n";
		$data .= "url('{$path}{$filename}.svg#{$family}') format('svg');"."\n";
		$data .= "font-weight: normal;"."\n";
		$data .= "font-style: normal;"."\n";
		$data .= "}"."\n";
		
		return $data;
	}
	
	// AUTO-LOAD FONTS
	static function auto_load_webfonts($path='../fonts/autoload/') {
		// INIT
		$css = '';
		if(substr($path, -1) != '/') { $path .= '/'; }
		
		// IF PATH IS AUTOLOAD FOLDER
		if($path == '../fonts/autoload/') {
			// GET FOLDER LIST
			$folders = misc::scan_dir($path);
			
			// LOOP THROUGH FOLDERS
			foreach($folders as $folder) {
				// DO NOT LOOK AT SYSTEM FOLDERS
				if($folder != '.' && $folder != '..') {
					// IF FOLDER IS ACTUALLY A FOLDER
					if(is_dir($path.$folder)) {
						// FIX PATHS ON STYLES
						$stylesheet = file_get_contents($path.$folder.'/stylesheet.css');
						$css .= str_replace("url('","url('".$path.$folder.'/',$stylesheet);
					}
				}
			}
			
		}
		// IF PATH IS SOMETHING ELSE
		else {
			// FIX PATHS ON STYLES
			$stylesheet = file_get_contents($path.'/stylesheet.css');
			$css = str_replace("url('","url('".$path,$stylesheet);
		}
		
		return $css;
	}
}
?>