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
	overflow-x: auto;
	overflow-y: scroll;
	<?PHP echo css::hex2rgba('#000','0.3','background-color');?>
}

.overlay {
	display: none;
	position: absolute;
	top: 75px;
	left: 50%;
	z-index: 100;
	overflow: hidden;
	padding: 15px 0;
	background: #FFFFFF;
	width: 45em;
	margin-left: -22.5em;
	<?PHP echo css::gradient('#FFFFFF','#e5e5e5');?>
	<?PHP echo css::border_radius('10px');?>
}

.overlay.big {
	width: 60em;
	margin-left: -30em;
}

.overlay .close_overlay {
	background-image: url('../images/icons/icon_close_01.png');
	background-size: 32px 32px;
	height: 30px;
	width: 30px;
	z-index: 150;
	position: absolute;
	top: 0px;
	right: 20px;
	cursor: pointer;
}
/* END MASK AND OVERLAY STYLES */

/* FORM STYLES */
input, textarea, select {
	border: solid 1px #d8d8d8;
	color: #016c8b;
	padding: 5px;
	<?PHP echo css::border_radius('5px');?>
}

textarea {
	height: 150px;
}

input:focus, textarea:focus {
	/*background: #FFFFCC;*/
}

input[type='checkbox'], input[type='radio'] {
	border: none;
}

label {
	font-weight: bold;
	padding: 5px;
}

form label {
	float: right;
}

.form_field {
	display: block;
	padding: 5px 0;
}

::-webkit-input-placeholder {
	color: #bebebe;
}

:-moz-placeholder {
	color: #bebebe;
}

.print_break {
	display: none;
}
/* END FORM STYLES */

/* BUTTON STYLES */
	/* LIGHT BUTTON STYLES (DEFAULT) */
.button {
	display: inline;
	cursor: pointer;
	line-height: 1em;
	margin: 3px 0;
	padding: 5px 10px;
	border: solid 1px #dbdbdb;
	color: #4f4f4f;
	background: #fefefe;
	outline: none;
	font-size: 1.2em;
	font-weight: bold;
	box-shadow: 0px 2px 0px #bfbfbf, 0px 3px 0px #e0e0e0;
	-moz-box-shadow: 0px 2px 0px #bfbfbf, 0px 3px 0px #e0e0e0;
	-webkit-box-shadow: 0px 2px 0px #bfbfbf, 0px 3px 0px #e0e0e0;
	<?PHP echo css::border_radius('5px');?>
	<?PHP echo css::text_shadow('0px','1px','0px','#FFFFFF');?>
	<?PHP echo css::gradient('#eaeaea','#cecece');?>
}

.button_hover, .button:hover {
	<?PHP echo css::gradient('#ffffff','#fafafa');?>
}

.button_active, .button_disabled, .button[disabled="disabled"], .button:active {
	margin-top: 5px;
	margin-bottom: 1px;
	<?PHP echo css::box_shadow('0px','0px','0px','#b6b6b6');?>
	<?PHP echo css::gradient('#f3f3f3','#ffffff');?>
}

.button.busy {
	color: #b42121;
}

.button_disabled, .button[disabled="disabled"] {
	color: #d1d1d1;
}
	/* DARK BUTTON STYLES */
.button.dark {
	color: #FFFFFF;
	border-color: #959595;
	box-shadow: 0px 2px 0px #707070, 0px 3px 0px #e0e0e0;
	-moz-box-shadow: 0px 2px 0px #707070, 0px 3px 0px #e0e0e0;
	-webkit-box-shadow: 0px 2px 0px #707070, 0px 3px 0px #e0e0e0;
	<?PHP echo css::text_shadow('0px','-1px','0px','#000000');?>
	<?PHP echo css::gradient('#9c9c9c','#838483');?>
}

.dark.button_hover, .dark.button:hover {
	<?PHP echo css::gradient('#c6c6c6','#adadad');?>
}

.dark.button_active, .button[disabled="disabled"].dark, .dark.button:active {
	margin-top: 5px;
	margin-bottom: 1px;
	<?PHP echo css::box_shadow('0px','0px','0px','#b6b6b6');?>
	<?PHP echo css::gradient('#7d7d7d','#949494');?>
}

.dark.button.busy {
	color: #ffff80;
}

.button_disabled, .button[disabled="disabled"].dark {
	color: #b1b1b1;
}
/* END BUTTON STYLES */

/* 960 HELPERS */
.no_margin {
	width: 960px !important;
	margin-left: 0;
	margin-right: 0;
}

/* NOTIFICATION BOXES */
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
	background: url('../images/bullets.png') no-repeat -0px -0px;
	width: 32px;
	height: 32px;
}

.nivo-controlNav a:hover, .nivo-controlNav a.active {
	background-position: 0 -96px;
}

/* GENERAL HELPERS */
.bold {
	font-weight: bold;
}

.italic {
	font-style: italic;
}

.left {
	text-align: left;
}

.right {
	text-align: right;
}

.center {
	text-align: center;
}

.heading {
	display: block;
}

.border_all_5 {
	<?PHP echo css::border_radius('5px');?>
}

.border_all_10 {
	<?PHP echo css::border_radius('10px');?>
}

.border_all_15 {
	<?PHP echo css::border_radius('15px');?>
}

.border_top_5 {
	<?PHP echo css::border_radius('5px','TOP');?>
}

.border_bottom_5 {
	<?PHP echo css::border_radius('5px','BOTTOM');?>
}

.border_top_10 {
	<?PHP echo css::border_radius('10px','TOP');?>
}

.border_bottom_10 {
	<?PHP echo css::border_radius('10px','BOTTOM');?>
}

.border_top_15 {
	<?PHP echo css::border_radius('15px','TOP');?>
}

.border_bottom_15 {
	<?PHP echo css::border_radius('15px','BOTTOM');?>
}

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

.engrave_dark {
	text-shadow: 1px -1px 1px #000;
}

.engrave_light{
	text-shadow: 1px -1px 1px #FFF;
}

/* BULLETS */
.bullet_black { background: url('../images/bullets.png') no-repeat -0px -0px; }
.bullet_yellow { background: url('../images/bullets.png') no-repeat -0px -32px; }
.bullet_blue { background: url('../images/bullets.png') no-repeat -0px -64px; }
.bullet_green { background: url('../images/bullets.png') no-repeat -0px -96px; }
.bullet_red { background: url('../images/bullets.png') no-repeat -0px -128px; }
.bullet_grey { background: url('../images/bullets.png') no-repeat -0px -160px; }

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