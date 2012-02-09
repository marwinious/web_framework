<?php
header('Content-type: text/javascript');
//ob_start('ob_gzhandler');
ob_start("compress");
function compress($buffer) {
	 /* remove comments */
	//$buffer = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $buffer);
	/* remove tabs, spaces, newlines, etc. */
	//$buffer = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $buffer);
	/* remove other spaces before/after ) */
	//$buffer = preg_replace(array('(( )+\))','(\)( )+)'), ')', $buffer);
	return $buffer;
}

/* your js files */
include("../../config.php");
foreach($_compress['js'] as $key => $value) {
	echo "\r\n";
	include("../../$value");
}

ob_end_flush();
?>