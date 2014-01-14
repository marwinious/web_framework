<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>

/* HELPER STYLES */

.bold { font-weight: bold; }

.italic { font-style: italic; }

.text-left {	text-align: left; }

.text-right { text-align: right; }

.text-center { text-align: center; }

.float-left { float: left; }

.float-right { float: right; }

.hide { display: none; }

.highlight { background: #ffff99; }

.engrave_dark { text-shadow: 1px -1px 1px #000; }

.engrave_light{ text-shadow: 1px -1px 1px #FFF; }

.border_all_5 { <?PHP echo css::border_radius('5px');?> }

.border_all_10 { <?PHP echo css::border_radius('10px');?> }

.border_all_15 {	<?PHP echo css::border_radius('15px');?> }

.border_top_5 { <?PHP echo css::border_radius('5px','TOP');?> }

.border_bottom_5 { <?PHP echo css::border_radius('5px','BOTTOM');?> }

.border_top_10 { <?PHP echo css::border_radius('10px','TOP');?> }

.border_bottom_10 { <?PHP echo css::border_radius('10px','BOTTOM');?> }

.border_top_15 { <?PHP echo css::border_radius('15px','TOP');?> }

.border_bottom_15 { <?PHP echo css::border_radius('15px','BOTTOM');?> }

	/* BULLETS */
.bullet_black { background: url('../images/icons/bullets.png') no-repeat -0px -0px; }
.bullet_yellow { background: url('../images/icons/bullets.png') no-repeat -0px -32px; }
.bullet_blue { background: url('../images/icons/bullets.png') no-repeat -0px -64px; }
.bullet_green { background: url('../images/icons/bullets.png') no-repeat -0px -96px; }
.bullet_red { background: url('../images/icons/bullets.png') no-repeat -0px -128px; }
.bullet_grey { background: url('../images/icons/bullets.png') no-repeat -0px -160px; }

/* END HELPER STYLES */