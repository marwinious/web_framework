<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>

/* CORE MENU STYLES */

.core_menu {
	margin: 0;
	padding: 0;
	line-height: 100%;
	display: inline-block;
	z-index: 1;
	<?PHP echo css::box_shadow('0px','1px','3px','0px','rgba(0,0,0,.4)');?>
}

.core_menu li {
	float: left;
	position: relative;
	list-style: none;
	overflow: visible;
	display: block;
	z-index: 2;
}


/* main level link */
.core_menu a {
	font-weight: bold;
	color: #5b5b5b;
	text-decoration: none;
	display: block;
	padding:  8px 20px;
	margin: 0;
	border: solid 1px transparent;
	<?PHP echo css::gradient('#fbfbfb','#e9e9e9');?>
	<?PHP echo css::text_shadow('0px','1px','1px','rgba(0,0,0,.3)');?>
}

.core_menu a:hover {
	background: #000;
	color: #fff;
}

/* main level link hover */
.core_menu .current a, .core_menu li:hover > a {
	color: #444;
	border: solid 1px #EEE;
	<?PHP echo css::gradient('#e2e2e2','#f5f5f5');?>
}

/* sub levels link hover */
.core_menu ul li:hover a, .core_menu li:hover li a {
	border: none;
	color: #666;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
}

.core_menu ul a:hover {
	background: #d1d1d1;
	filter: none;
	<?PHP echo css::text_shadow('0px','1px','1px','rgba(0,0,0,.1)');?>
}

/* dropdown */
.core_menu li:hover > ul {
	display: block;
}

/* level 2 list */
.core_menu ul {
	display: none;
	margin: 0;
	padding: 0;
	width: 185px;
	position: absolute;
	top: 30px; /* should be same as 'a' height */
	left: 0;
	background: #ddd;
	border: solid 1px #b4b4b4;
	<?PHP echo css::box_shadow('0px','1px','3px','0px','rgba(0,0,0,.3)');?>
}

.core_menu ul li {
	float: none;
	margin: 0;
	padding: 0;
}

.core_menu ul a {
	font-weight: normal;
	text-shadow: 0 1px 0 #fff;
	background: none;
	filter: none;
}

/* level 3+ list */
.core_menu ul ul {
	left: 181px;
	top: 3px;
}

/* clearfix */
.core_menu:after {
	content: ".";
	display: block;
	clear: both;
	visibility: hidden;
	line-height: 0;
	height: 0;
}

/* END CORE MENU STYLES