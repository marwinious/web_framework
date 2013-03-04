<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>

/* MAIN ELEMENT STYLES */
html {
	font-size: 62.5%;
}

body {
	font-size: 1.2em;
	color: #5D5D5D;
	overflow: scroll;
}

a { text-decoration: none; }
/* END MAIN ELEMENT STYLES */

/* MASK AND OVERLAY STYLES */
#mask {
	display: none;
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;
	right: 0;
	z-index: 99;
	overflow: hidden;
	<?PHP echo css::hex2rgba('#000','0.3','background-color');?>
}

.overlay {
	display: none;
	position: fixed;
	top: 25%;
	left: 50%;
	z-index: 100;
	overflow: hidden;
	padding: 10px;
	background: #FFFFFF;
	width: 56em;
	height: 50%;
	margin-left: -28em;
	<?PHP echo css::gradient('#FFFFFF','#e5e5e5');?>
	<?PHP echo css::border_radius('10px');?>
}

.overlay .close_overlay {
	background-image: url('../images/icons/icon_close_01.png');
	background-size: 32px 32px;
	height: 30px;
	width: 30px;
	z-index: 150;
	position: absolute;
	top: 1px;
	right: 4px;
	cursor: pointer;
}

.overlay .overlay_header {
	display: block;
	color: inherit;
	margin: 0;
	padding: 0;
	font-size: 2em;
	border-bottom: dotted 1px #DDDDDD;
}

.overlay_content {
	display: block;
	height: 95%;
}

.overlay .row {
	min-width: 0;
}
/* END MASK AND OVERLAY STYLES */

/* FORM STYLES */
.form_field {
	display: block;
	padding: 5px 0;
}

.print_break {
	display: none;
}
/* END FORM STYLES */

/* 960 HELPERS */
.no_margin {
	width: 960px !important;
	margin-left: 0;
	margin-right: 0;
}

/* AUTOCOMPLETE STYLES */
.auto_complete_results {
	border: solid 1px #E4E4E4;
	font-size: 1.2em;
	padding: 3px;
	overflow: hidden;
	position: absolute;
	background: #FFF;
	z-index: 1000;
}

.auto_complete_results ul {
	list-style: none;
	margin: 0px;
	padding: 0px;
}

.auto_complete_results ul li {
	margin: 0px;
	padding: 0px;
}

.auto_complete_results ul li:hover {
	background: #F4E7BD;
}

.auto_complete_results ul li a {
	color: #696969;
}

.auto_complete_match {
	font-weight: bold;
}

/* NIVO SLIDER OPTIONS */
.nivo-controlNav {
	position: absolute;
	top: 275px;
	left: 10px;
}

.nivo-controlNav a {
	text-indent: -9999px;
	float: left;
	background: url('../images/icons/bullets.png') no-repeat -0px -0px;
	width: 32px;
	height: 32px;
}

.nivo-controlNav a:hover, .nivo-controlNav a.active {
	background-position: 0 -96px;
}

/* GENERAL HELPERS */
.tooltip:hover:after {
	content: attr(tooltip);
	position: relative;
	top: 15px;
	left: 3px;
	background: #363636;
	color: #FFFFFF;
	padding: 5px;
	<?PHP echo css::border_radius('5px');?>
}

/* CALENDAR STYLES */
table.calendar {
	width: 100%;
	margin: 10px 0;
}

tr.calendar-row {

}

th.calendar-header {
	font-size: 1.6em;
	text-align: center;
	padding: 5px 0;
}

th.calendar-day-head {
	background: #e5e5e5;
	height: 30px;
	width: 14.285%;
	text-align: center;
	border: solid 1px #5D5D5D;
	vertical-align: middle;
}

td.calendar-day {
	height: 80px;
	border: solid 1px #5D5D5D;
	vertical-align: top;
	padding-top: 30px;
}

td.calendar-day p {
	background: #fff5ce;
	border-top: solid 1px #ffde59;
	border-bottom: solid 1px #ffde59;
	margin-bottom: 3px;
	padding: 0 4px;
}

td.calendar-day-np {
	background: #eeeeee;
	border: solid 1px #5D5D5D;
}

div.day-number {
	background: #5D5D5D;
	padding: 5px;
	font-weight: bold;
	float: right;
	min-width: 30px;
	text-align: center;
	color: #FFFFFF;
	position: relative;
	top: -30px;
}