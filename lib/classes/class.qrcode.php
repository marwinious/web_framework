<?PHP
/*
EXAMPLE HTML:

<div id="qrcode"></div>

<script type="text/javascript">
<!--
$("#qrcode").qrcode({
	text: "My message",
	width: 150,
	height: 150,
	typeNumber: 10 // DENOTES CHARACTER LIMIT. LARGER = MORE CHARS, SMALLER SQUARES
});
// -->
</script>
*/

class qrcode {

	function create($type,$body,$smsto="",$clean=0) {
		$error = false;
		$qrcode = "";
		
		if($clean) {$body = $this->clean($body);}
	
		// CHECK QRCODE TYPE
		switch($type) {
			case "URL":
				$qrcode = $body;
				break;
			
			case "TEXT":
				$qrcode = $body;
				break;
				
			case "PHONE":
				$qrcode = "TEL:".$body;
				break;
				
			case "SMS":
				$qrcode = "SMSTO:".$smsto.":".$body;
				break;
			
			default:
				$error = true;
				break;
		}
		
		if($error) { return false; }
		else { return $qrcode; }
	}
	
	function clean($text) {
		$find = array(" ",":","/","'","?");
		$replace = array("%20","%3A","%2F","%27","%3F");
		
		$text = str_replace($find,$replace,$text);
		
		return $text;
	}
}
?>