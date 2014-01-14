<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>
@media print {

	body {
		overflow: visible;
	}
	
	.print_break {
		display:block; 
		page-break-before:always;
	}

}