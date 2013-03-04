<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>

/* NOTIFICATION STYLES */

.error, .notice, .inform, .success {
	padding: 10px;
	font-size: 1.4em;
}

.error {
	background: #FBE3E4;
	border: solid 3px #FBC2C4;
	color: #8A1F11;
}

.error a {
	text-decoration: underline;
	color: #8A1F11;
}

.notice {
	background: #FFF6BF;
	border: solid 3px #FFD324;
	color: #514721;
}

.notice a {
	text-decoration: underline;
	color: #514721;
}

.inform {
	background: #D5EDF8;
	border: solid 3px #92CAE4;
	color: #205791;
}

.inform a {
	text-decoration: underline;
	color: #205791;
}

.success {
	background: #E6EFC2;
	border: solid 3px #C6D880;
	color: #264409;
}

.success a {
	text-decoration: underline;
	color: #264409;
}

/* END NOTIFICATION STYLES */