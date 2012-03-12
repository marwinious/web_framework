<?PHP
class css {
	// LOAD CSS FILES FROM CSS FOLDER
	static function load_css($path) {
		GLOBAL $enable_phpcss;
		
		$files = scandir($path);
		$css = array();
		foreach($files as $key=>$value) {
			if($value != "." && $value != ".." && $value != "compress_stylesheets.php") {
				$split = explode('.',$value);
				if($enable_phpcss) {
					if(end($split) == "css" || end($split) == "php") {
						$css[] = CSS.$value;
					}
				}
				else {
					if(end($split) == "css") {
						$css[] = CSS.$value;
					}
				}
			}
		}
		
		return $css;
	}
	
	// GRADIENT
	static function gradient($start,$stop) {
		// OLD/UNSUPPORTED BROWSERS
		$data = "background-color: $start;\n";
	
		// FIREFOX
		$data .= "background-image: -moz-linear-gradient(100% 100% 90deg, $stop, $start);\n";
		
		// WEBKIT
		$data .= "background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from($start), to($stop));\n"; // OLDER
		$data .= "background: -webkit-linear-gradient(top, $start 0%,$stop 100%);\n"; //NEWER
		
		// OPERA
		$data .= "background: -o-linear-gradient(top, $start 0%,$stop 100%);\n";
		
		// IE
		$data .= "background: -ms-linear-gradient(top, $start 0%,$stop 100%);\n"; // 10+
		$data .= "filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='$start', EndColorStr='$stop');\n";
		
		// W3C
		$data .= "background: linear-gradient(top, $start 0%,$stop 100%);\n";
		
		return $data;
	}
	
	// ROUNDED CORNERS
	static function border_radius($radius,$target="all") {
		// DETERMINE TARGET
		switch(strtoupper($target)) {
			case "ALL":
				// FIREFOX
				$data = "-moz-border-radius: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-radius: $radius;\n";
				// W3C
				$data .= "border-radius: $radius;\n";
				break;
				
			case "TOP":
				// FIREFOX
				$data = "-moz-border-radius-topleft: $radius;\n -moz-border-radius-topright: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-top-left-radius: $radius;\n -webkit-border-top-right-radius: $radius;\n";
				// W3C
				$data .= "border-top-left-radius: $radius;\n border-top-right-radius: $radius;\n";
				break;
				
			case "TOP-RIGHT":
				// FIREFOX
				$data = "-moz-border-radius-topright: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-top-right-radius: $radius;\n";
				// W3C
				$data .= "border-top-right-radius: $radius;\n";
				break;
				
			case "TOP-LEFT":
				// FIREFOX
				$data = "-moz-border-radius-topleft: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-top-left-radius: $radius;\n";
				// W3C
				$data .= "border-top-left-radius: $radius;\n";
				break;
				
			case "BOTTOM":
				// FIREFOX
				$data = "-moz-border-radius-bottomleft: $radius;\n -moz-border-radius-bottomright: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-bottom-left-radius: $radius;\n -webkit-border-bottom-right-radius: $radius;\n";
				// W3C
				$data .= "border-bottom-left-radius: $radius;\n border-bottom-right-radius: $radius;\n";
				break;
				
			case "BOTTOM-RIGHT":
				// FIREFOX
				$data = "-moz-border-radius-bottomright: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-bottom-right-radius: $radius;\n";
				// W3C
				$data .= "border-bottom-right-radius: $radius;\n";
				break;
				
			case "BOTTOM-LEFT":
				// FIREFOX
				$data = "-moz-border-radius-bottomleft: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-bottom-left-radius: $radius;\n";
				// W3C
				$data .= "border-bottom-left-radius: $radius;\n";
				break;
				
			case "RIGHT":
				// FIREFOX
				$data = "-moz-border-radius-topright: $radius;\n -moz-border-radius-bottomright: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-top-right-radius: $radius;\n -webkit-border-bottom-right-radius: $radius;\n";
				// W3C
				$data .= "border-top-right-radius: $radius;\n border-bottom-right-radius: $radius;\n";
				break;
				
			case "LEFT":
				// FIREFOX
				$data = "-moz-border-radius-topleft: $radius;\n -moz-border-radius-bottomleft: $radius;\n";
				// WEBKIT
				$data .= "-webkit-border-top-left-radius: $radius;\n -webkit-border-bottom-left-radius: $radius;\n";
				// W3C
				$data .= "border-top-left-radius: $radius;\n border-bottom-left-radius: $radius;\n";
				break;
		}
		
		
		return $data;
	}
	
	// BOX SHADOW
	static function box_shadow($x,$y,$blur,$color,$inset=false) {
		// CHECK FOR INSET
		if($inset && !empty($inset)) {
			$inset = "inset";
		}
		
		// FIREFOX
		$data = "-moz-box-shadow:{$inset} {$x} {$y} {$blur} $color;\n";
		
		// WEBKIT
		$data .= "-webkit-box-shadow:{$inset} {$x} {$y} {$blur} $color;\n";
		
		// W3C
		$data .= "box-shadow:{$inset} {$x} {$y} {$blur} $color;\n";
		
		return $data;
	}
	
	// TEXT SHADOW
	static function text_shadow($x,$y,$blur,$color) {
		// W3C
		$data = "text-shadow: {$x} {$y} {$blur} $color;\n";
		
		// IE
		$data .= "filter: dropshadow(color={$color},offx={$x},offy={$y});\n";
		
		return $data;
	}
	
	// TRANSFORM EFFECT
	static function transform($scale,$rotate,$transX="0",$transY="0",$skewX="0",$skewY="0") {
		// FIREFOX
		$data = "-moz-transform: scale({$scale}) rotate({$rotate}deg) translate({$transX}, {$transY}) skew({$skewX}deg, {$skewY}deg);\n";
		
		// WEBKIT
		$data .= "-webkit-transform: scale({$scale}) rotate({$rotate}deg) translate({$transX}, {$transY}) skew({$skewX}deg, {$skewY}deg);\n";
		
		// OPERA
		$data .= "-o-transform: scale({$scale}) rotate({$rotate}deg) translate({$transX}, {$transY}) skew({$skewX}deg, {$skewY}deg);\n";
		
		// IE
		$data .= "-ms-transform: scale({$scale}) rotate({$rotate}deg) translate({$transX}, {$transY}) skew({$skewX}deg, {$skewY}deg);\n";
		
		// W3C
		$data .= "transform: scale({$scale}) rotate({$rotate}deg) translate({$transX}, {$transY}) skew({$skewX}deg, {$skewY}deg);\n";
		
		return $data;
	}
	
	// CONVERT HEX COLORS TO RGB COLORS
	static function hex2rgba($hex,$alpha="1.0",$element="") {
		// CONVERT HEX TO RGB
		if($hex[0] == "#") { $hex = substr($hex,1); } // REMOVE # IF EXISTS
		
		// PROCESS ACCORDING TO HEX LENGTH
		switch(strlen($hex)) {
			case 6:
				list($r,$g,$b) = array($hex[0].$hex[1],
									   $hex[2].$hex[3],
									   $hex[4].$hex[5]);
				
				break;
				
			case 3:
				list($r,$g,$b) = array($hex[0].$hex[0],
									   $hex[1].$hex[1],
									   $hex[2].$hex[2]);
				
				break;
				
			default:
				return false;
		}
		
		if(isset($r)) {
			$r = hexdec($r);
			$g = hexdec($g);
			$b = hexdec($b);
		}
		
		if(!empty($element)) {
			if(substr($element,-1) != ":") { $element .= ":"; }
			$data = "$element #$hex;\n";
			$data .= "$element rgba($r,$g,$b,$alpha);\n"; 
		}
		else {
			$data = "rgba($r,$g,$b,$alpha);\n"; 
		}
		
		return $data;	
	}
	
	// FONT-FACE FONTS
	static function font($family,$path,$file) {
		$data = "@font-face {\n";
		$data .= "font-family: '$family';\n";
		$data .= "src: url('{$path}/{$file}.eot');";
		$data .= "src: url('{$path}/{$file}.eot?iefix') format('embedded-opentype'),";
		$data .= "url('{$path}/{$file}.woff') format('woff'),";
		$data .= "url('{$path}/{$file}.ttf') format('truetype'),";
		$data .= "url('{$path}/{$file}.svg#{$family}') format('svg');";
		$data .= "font-weight: normal;\n";
		$data .= "font-style: normal;\n";
		$data .= "}\n";
		
		return $data;
	}
	
	// ANIMATED TRANSITIONS
	static function transition($property="all",$duration="0.3s",$easing="ease",$delay="0s") {
		// OPTIONS
		// EASING: linear, ease, ease-in, ease-out, ease-in-out, cubic-bezier(n,n,n,n) (n range = 0 to 1)
		
		$data = "";
		
		// FIREFOX
		$data .= "-moz-transition: {$property} {$duration} {$easing} {$delay};\n";
		
		// WEBKIT
		$data .= "-webkit-transition: {$property} {$duration} {$easing} {$delay};\n";
		
		// OPERA
		$data .= "-o-transition: {$property} {$duration} {$easing} {$delay};\n";
		
		// W3C
		$data .= "transition: {$property} {$duration} {$easing} {$delay};\n";
		
		return $data;
	}
	
	// OPACITY
	static function opacity($value) {
		$data = "";
	
		// W3C
		$data .= "opacity: {$value};\n";
		
		// IE6-8
		$value = $value*10;
		$data .= "filter: alpha(opacity={$value});\n";
		
		return $data;
	}
}
?>
