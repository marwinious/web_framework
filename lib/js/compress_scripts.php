<?php
header('Content-type: text/javascript');
//ob_start('ob_gzhandler');
ob_start("compress");
function compress($buffer) {
	// REMOVE COMMENTS BLOCKS, TABS
	$buffer = preg_replace("/\/\*([\s\S]*?)\*\/|\t+/i","", $buffer);
	// REMOVE EXTRA SPACES
	$buffer = preg_replace("/ {2,}/i"," ", $buffer);
	return $buffer;
}

/* your js files */
include("../../config.php");
foreach($_SESSION['_header']['js'] as $key => $value) {
	echo "\r\n";
	include("../../$value");
}

ob_end_flush();
?>