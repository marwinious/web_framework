<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>

/* FORM STYLES */

form input, form textarea, form select {
	border: solid 1px #d8d8d8;
	color: #016c8b;
	padding: 5px;
	<?PHP echo css::border_radius('5px');?>
}

form textarea {
	height: 150px;
}

form input:focus, form textarea:focus {
	
}

form input[type='checkbox'], form input[type='radio'] {
	border: none;
}

form label {
	float: right;
}

label {
	font-weight: bold;
	padding: 5px;
}

::-webkit-input-placeholder {
	color: #bebebe;
}

:-moz-placeholder {
	color: #bebebe;
}

textarea { height: auto; }

select { width: 100%; }


/* END FORM STYLES */