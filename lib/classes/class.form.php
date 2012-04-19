<?PHP
class form {
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
				
			case "FILE":
				$input = "<input type=\"file\" name=\"$name\" value=\"$value\"";
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
}
?>