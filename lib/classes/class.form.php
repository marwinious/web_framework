<?PHP
class form {
	// CREATES INPUT ELEMENT
	static function input($type,$name,$value="",$options="") {
		// CHECK TYPE
		switch(strtoupper($type)) {
			case "TEXT": case "HIDDEN": case "PASSWORD": case "SUBMIT": case "RESET": case "CHECKBOX": case "RADIO": case "FILE": case "TEL": case "EMAIL":
				$input = "<input type=\"{$type}\" name=\"{$name}\" id=\"{$name}\" value=\"{$value}\"";
				break;
			
			default:
				$input = "<input type=\"{$type}\" name=\"{$name}\" id=\"{$name}\" value=\"{$value}\"";
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
		$button = "<button type=\"{$type}\" {$options}>{$text}</button>";
		return $button;
	}
}
?>