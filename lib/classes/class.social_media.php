<?PHP
class facebook {
	/*
	USAGE: Put 'echo $fb->output_js();' somewhere within your body tag on the page(s) your button with reside on. To generate link, include this class then set options:
	$fb = new facebook();
	$fb->set_share_link("http://www.google.com");
	$fb->set_share_title("Google Homepage");
	Finally, print link: echo $fb->output_share();
	To clear FB like/share cache: https://developers.facebook.com/tools/debug
	*/
	
	function __construct() {
		// SET DEFAULTS
		$this->share_icon = "lib/images/icons/facebook_32.png";
		$this->share_link = "";
		$this->share_title = "";
		$this->share_js = "<script src=\"http://static.ak.fbcdn.net/connect.php/js/FB.Share\" type=\"text/javascript\"></script><script type=\"text/javascript\">$(\".facebook_share\").click(function(){ window.open($(this).attr('href'),'Share on Facebook','width=640,height=400');return false; });</script>";
		$this->share_link_template = "http://www.facebook.com/sharer.php?u=<url to share>&t=<title of content>";
	}
	
	// PRINT REQUIRED JAVASCRIPT (ONLY NEEDED ONCE PER PAGE)
	function output_js() {
		return $this->share_js;
	}
	
	// GENERATE SHARE LINK
	function output_share($type="SIMPLE") {
		$share = "";
		
		// REPLACEMENT SETTINGS
		$find = array("<url to share>","<title of content>");
		$replace = array($this->share_link,$this->share_title);
	
		// CHECK TYPE
		switch(strtoupper($type)) {
			case "SIMPLE":
				$share = "<a href=\"";
				$share .= str_replace($find,$replace,$this->share_link_template);
				$share .= "\" class=\"facebook_share\"><img src=\"{$this->share_icon}\" alt=\"Share on Facebook\" /></a>";
				break;
				
			case "STANDARD":
				
				break;
		}
		
		return $share;
	}
	
	// CHANGE ICON TO DISPLAY ON PAGE
	function set_share_icon($image_url) {
		$this->share_icon = $image_url; return true;
	}
	
	// CHANGE LINK TO SHARE
	function set_share_link($link) {
		$this->share_link = urlencode($link); return true;
	}
	
	// CHANGE TEXT FOR LINK
	function set_share_title($title) {
		$this->share_title = urlencode($title); return true;
	}
}
?>