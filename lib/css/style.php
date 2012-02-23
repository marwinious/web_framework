<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>
/* HTML 5 PRESETS */
header, section, article, footer, nav, aside {
	display: block;
}
/* END HTML 5 PRESETS */

/* MAIN STYLES */
html {
	font-size: 62.5%;
}

body {
	font-family: arial;
	font-size: 1.2em;
	color: #5D5D5D;
	overflow: scroll;
}

a:link, a:visited {
	color: #0080ff;
	text-decoration: none;
}

a:hover {
	color: #8000ff;
	text-decoration: none;
}

p, ul, ol, td, th, caption {
	
}

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
	top: 200px;
	z-index: 100;
	overflow: hidden;
	padding: 15px 0;
	background: #FFFFFF;
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
	top: 0px;
	right: 10px;
	cursor: pointer;
}
/* END MAIN STYLES */

/* FORM STYLES */
input, textarea, select {
	border: solid 1px #d8d8d8;
	color: #016c8b;
}

input:focus, textarea:focus {
	background: #ffffb0;
}

input[type='checkbox'], input[type='radio'] {
	border: none;
}

label {
	font-weight: bold;
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