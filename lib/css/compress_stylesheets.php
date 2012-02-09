<?php
header('Content-type: text/css');
ob_start("compress");
function compress($buffer) {
	/* remove comments */
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	/* remove tabs, spaces, newlines, etc. */
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer;
}

/* your css files */
include("../../config.php");
foreach($_compress['css'] as $key => $value) {
	include("../../$value");
}

ob_end_flush();
?>