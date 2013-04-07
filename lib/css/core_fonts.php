<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");
require_once("../classes/class.loader.php");
require_once("../classes/class.misc.php");

// REQUIRED THESE FONTS
echo loader::auto_load_webfonts('../fonts/Ubuntu/');
echo loader::auto_load_webfonts('../fonts/Luxi-Sans/');
echo loader::auto_load_webfonts('../fonts/web-symbols/');
echo loader::auto_load_webfonts('../fonts/heydings-common-icons/');
echo loader::auto_load_webfonts('../fonts/modern-pictograms/');

// AUTO-LOAD ADDITIONAL FONTS
echo loader::auto_load_webfonts();
?>