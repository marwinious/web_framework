<?PHP
class image {
	// IMAGE HELPER TO INSURE PROPER IMAGE FORMATTING ACROSS THE ENTIRE SITE.
	// EXPECTS SRC, TITLE, ALT TEXT, AND ANY ADDITIONAL PARAMETERS.
	static function make($src, $alt="", $title="", $extras="") {
		if($title == "") {
			if($alt != "") { $title = $alt;	}
			else { $title = $src; }
		}
		if(strtoupper($alt) == "NA" || strtoupper($title) == "NA") {
			$alt = "";
			$title = "";
		}
		
		$image = "<img src=\"$src\" alt=\"$alt\" title=\"$title\" ";
		
		if(is_array($extras)) {
			foreach($extras as $key => $value) {
				$image .= $value;
			}
		}
		else {
			$image .= $extras;
		}
		
		$image .= " />";
		
		return $image;
	}
}
?>