<?PHP
class standards {
	// FORMAT DATE TO DATABASE FORMATR
	static function dateToYMD($date) {
		$date = str_replace('-','/',$date);
		return date('Y-m-d', strtotime($date));
	}
	
	// FORMAT DATE TO HUMAN
	static function dateToHuman($date) {
		$date = str_replace('-','/',$date);
		return date('m/d/Y', strtotime($date));
	}
	
	// FORMAT DATE/TIME TO HUMAN
	static function dateTimeToHuman($date) {
		$date = str_replace('-','/',$date);
		return date('m/d/Y g:i a', strtotime($date));
	}
	
	// FORMAT DATE TO CUSTOM
	static function dateToCustom($format,$date) {
		$date = str_replace('-','/',$date);
		return date("$format",strtotime($date));
	}
	
	// IMAGE HELPER TO INSURE PROPER IMAGE FORMATTING ACROSS THE ENTIRE SITE.
	// EXPECTS SRC, TITLE, ALT TEXT, AND ANY ADDITIONAL PARAMETERS.
	static function image($src, $alt="", $title="", $extras="") {
		if($title == "") {
			if($alt != "") { $title = $alt;	}
			else { $title = $src; }
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
	
	// CREATES INPUT ELEMENT
	static function input($type,$name,$value="",$options="") {
		// CHECK TYPE
		switch(strtoupper($type)) {
			case "TEXT":
				$input = "<input type=\"text\" name=\"$name\" id=\"$name\" value=\"$value\"";
				break;
			
			case "HIDDEN":
				$input = "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"$value\"";
				break;
				
			case "CHECKBOX":
				$input = "<input type=\"checkbox\" name=\"".$name."\" value=\"$value\"";
				break;
				
			case "PASSWORD":
				$input = "<input type=\"password\" name=\"$name\" id=\"$name\" value=\"$value\"";
				break;
				
			case "RADIO":
				$input = "<input type=\"radio\" name=\"$name\" value=\"$value\"";
				break;
				
			case "SUBMIT":
				$input = "<input type=\"submit\" name=\"$name\" value=\"$value\"";
				break;
				
			case "RESET":
				$input = "<input type=\"reset\" name=\"$name\" value=\"$value\"";
				break;
				
			default:
				return false;
				break;
		}
		
		// CHECK OPTIONS
		if(is_array($options)) {
			if(in_array("checked",$options)) { $input .= " checked"; }
			if(in_array("disabled",$options)) { $input .= " disabled"; }
		}
		else {
			$input .= " $options";
		}
		
		// CLOSE INPUT AND RETURN
		$input .= " />";
		return $input;
	}
	
	// CREATE A BUTTON
	static function button($type,$text,$options="") {
		// CHECK FOR CLASS DECLARATION IN OPTIONS.
		// ADD 'BUTTON' CLASS.
		$found = strpos($options,"class='");
		if(!empty($found) || $found === 0) {
			$options = str_replace("class='","class='button ",$options);
		}
		else {
			$options .= " class='button'";
		}
		
		// GENERATE BUTTON STRING
		$button = "<button type=\"$type\" ".$options.">$text</button>";
		return $button;
	}
	
	// FIX EMPTY DATES
	function fix_empty_date($date,$replace_with='') {
		if($date == '0000-00-00' || $date == '00/00/0000' || $date == '0000-00-00 00:00:00' || $date == '1969-12-31' || $date == '1969-12-31 00:00:00') {
			$date = '';
		}
		else {
			$date = standards::dateToHuman($date);
		}
		
		return $date;
	}
}
?>