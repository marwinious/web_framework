<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>

.button {
	cursor: pointer;
	position: relative;
    color: #4A4A4A;
    text-decoration: none;
    background-color: #DB5705;
	text-align: center;
	margin: 5px;
	display: inline-block;
    padding: 5px 15px;
	border: none;
	font-size: 1em;
	font-weight: normal;
	
    -webkit-box-shadow: 0px 4px 0px #79797B, 0px 4px 5px #49494A;
    -moz-box-shadow: 0px 4px 0px #79797B, 0px 4px 5px #49494A;
    box-shadow: 0px 4px 0px #79797B, 0px 4px 5px #49494A;
	
	<?PHP echo css::gradient('#f2f2f2','#dbdbdb');?>
	<?PHP echo css::border_radius('8px');?>
	<?PHP echo css::transition('all','.1s');?>
}

.button:active {
	top: 3px;
    -webkit-box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
    -moz-box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
    box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
}

.button:focus {
	outline: none;
}


button.button {
	border: none;
}

.button.flat {
	box-shadow: none;
	border-radius: 0;
	background: #f2f2f2;
	border: solid 1px #DDDDDD;
}

.button.flat:active {
	top: 0;
	box-shadow: none;
	background: #dbdbdb;
}

.button.dark {
	color: #FFFFFF;
	-webkit-box-shadow: 0px 4px 0px #404040, 0px 4px 5px #121212;
    -moz-box-shadow: 0px 4px 0px #404040, 0px 4px 5px #121212;
    box-shadow: 0px 4px 0px #404040, 0px 4px 5px #121212;
	<?PHP echo css::gradient('#858585','#575757');?>
}

.button.dark:active {
    -webkit-box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
    -moz-box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
    box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
}

.button.dark.flat {
	background: #6C6C6C;
	box-shadow: none;
	border: solid 1px #515151;
}

.button.dark.flat:active {
	background: #3E3E3E;
}

.button.blue {
	color: #FFFFFF;
	-webkit-box-shadow: 0px 4px 0px #2C5996, 0px 4px 5px #121212;
    -moz-box-shadow: 0px 4px 0px #2C5996, 0px 4px 5px #121212;
    box-shadow: 0px 4px 0px #2C5996, 0px 4px 5px #121212;
	<?PHP echo css::gradient('#5C8DCF','#3F78C7');?>
}

.button.blue:active {
    -webkit-box-shadow: 0px 1px 0px #2C5996, 0px 3px 3px #2F2F2F;
    -moz-box-shadow: 0px 1px 0px #2C5996, 0px 3px 3px #2F2F2F;
    box-shadow: 0px 1px 0px #2C5996, 0px 3px 3px #2F2F2F;
}

.button.blue.flat {
	background: #5C8DCF;
	box-shadow: none;
	border: solid 1px #3F78C7;
}

.button.blue.flat:active {
	background: #3F78C7;
}

.button.red {
	color: #FFFFFF;
	-webkit-box-shadow: 0px 4px 0px #8E130D, 0px 4px 5px #121212;
    -moz-box-shadow: 0px 4px 0px #8E130D, 0px 4px 5px #121212;
    box-shadow: 0px 4px 0px #8E130D, 0px 4px 5px #121212;
	<?PHP echo css::gradient('#E91F14','#BE1810');?>
}

.button.red:active {
    -webkit-box-shadow: 0px 1px 0px #8E130D, 0px 3px 3px #2F2F2F;
    -moz-box-shadow: 0px 1px 0px #8E130D, 0px 3px 3px #2F2F2F;
    box-shadow: 0px 1px 0px #8E130D, 0px 3px 3px #2F2F2F;
}

.button.red.flat {
	background: #CF1B12;
	box-shadow: none;
	border: solid 1px #BE1810;
}

.button.red.flat:active {
	background: #AC160F;
}

.button.green {
	color: #FFFFFF;
	-webkit-box-shadow: 0px 4px 0px #136C17, 0px 4px 5px #121212;
    -moz-box-shadow: 0px 4px 0px #136C17, 0px 4px 5px #121212;
    box-shadow: 0px 4px 0px #136C17, 0px 4px 5px #121212;
	<?PHP echo css::gradient('#1FBA26','#1A9720');?>
}

.button.green:active {
    -webkit-box-shadow: 0px 1px 0px #136C17, 0px 3px 3px #2F2F2F;
    -moz-box-shadow: 0px 1px 0px #136C17, 0px 3px 3px #2F2F2F;
    box-shadow: 0px 1px 0px #136C17, 0px 3px 3px #2F2F2F;
}

.button.green.flat {
	background: #1CA522;
	box-shadow: none;
	border: solid 1px #1A9720;
}

.button.green.flat:active {
	background: #17861D;
}

.share_button:before, .fb_button:before, .twitter_button:before, .linkedin_button:before, .comment_button:before, .email_button:before, .twitter_button:before, .like_button:before, .accept_button:before, .gplus_button:before, .decline_button:before, .rss_button:before, .settings_button:before {
	font-size: 1.4em;
	padding-right: 5px;
	font-family: 'WebSymbolsRegular';
	vertical-align: middle;
}

.share_button:before { content: 'i'; }

.fb_button:before {	content: 'f'; }

.twitter_button:before { content: 't'; }

.linkedin_button:before { content: 'l'; }

.comment_button:before { content: 'e'; }

.accept_button:before { content: '.'; }

.decline_button:before { content: '-'; }

.gplus_button:before { content: 'g'; }

.rss_button:before { content: 'r'; }

.settings_button:before { content: 'S'; }

.icon_close:before {
	font-family: 'ModernPictogramsNormal';
	content: 'x';
	display: inline-block;
	font-size: 2em;
	width: 24px;
	height: 24px;
}

.button[disabled], .button.disabled, .button[disabled].flat, .button.disabled.flat {
	background: #E5E5E5;
	color: #BCBCBC;
	-webkit-box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
    -moz-box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
    box-shadow: 0px 1px 0px #79797B, 0px 3px 3px #2F2F2F;
}

.button[disabled]:active, .button.disabled:active, .button[disabled].flat:active, .button.disabled.flat:active,
.button[disabled]:hover, .button.disabled:hover, .button[disabled].flat:hover, .button.disabled.flat:hover {
	top: 0;
	background: #E5E5E5;
}

.button[disabled].flat, .button.disabled.flat {
	box-shadow: none;
}