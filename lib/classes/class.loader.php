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
			$css[] = CSS.'autoload/'.$file;
		}
		
		// AUTO-LOAD JAVASCRIPT
		$autojs = misc::scan_dir(JS.'autoload/');
		foreach($autojs as $file) {
			$js[] = JS.'autoload/'.$file;
		}
		
		// LOAD CUSTOM STYLESHEETS
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
			// LOAD JS
			echo "<script type='text/javascript' src='".JS."compress_scripts.php'></script>\n";
			
			// LOAD CSS
			echo "<link rel='stylesheet' type='text/css' href='".CSS."compress_stylesheets.php' />\n";
			
			return $elements;
		}
		else {
			// LOAD JS
			foreach($elements['js'] as $element) {
				echo "<script type='text/javascript' src='{$element}'></script>\n";
			}
			// LOAD CSS
			foreach($elements['css'] as $element) {
				echo "<link rel='stylesheet' type='text/css' href='{$element}' />\n";
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
		GLOBAL $_metadata;
	
		foreach($_metadata as $key=>$value) {
			echo "{$value}\n";
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
		// GET A LIST OF FONTS FROM AUTOLOAD DIRECTORY
		$fonts = misc::scan_dir($path);
		// ISOLATE TTF FILES (FOR UNIQUENESS)
		$css = '';
		for($i=0;$i<count($fonts);$i++) {
			if(strpos($fonts[$i],'.ttf')) {
				// GET FONT FAMILY NAME
				$parts = explode('-',$fonts[$i]);
				$family = '';
				for($p=0;$p<count($parts);$p++) {
					if($parts[$p] != 'webfont.ttf') {
						$family .= $parts[$p];
					}
				}
				// GET FONT FILENAME
				$filename = str_replace('.ttf','',$fonts[$i]);
				// LOAD FONT CSS
				$css .= loader::load_webfont($family,$filename,$path)."\n";
			}
		}
		
		return $css;
	}
}
?>