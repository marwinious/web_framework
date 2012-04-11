<?PHP
// CONFIGURE ERROR REPORTING
// OPTIONS: 0 (OFF), E_ERROR|E_WARNING|E_PARSE (SIMPLE RUNNING ERRORS),
// E_NOTICE (REPORT UNINITIALIZED VARS AND MISSPELLINGS), E_ALL ^ E_NOTICE (OMITS E_NOTICE),
// E_ALL (ALL ERRORS), -1 (ALL ERRORS)
error_reporting(E_ALL);

// LOCALE SETTINGS
date_default_timezone_set('America/New_York');

// PATH CONSTANTS //
define("BASEPATH",dirname(__FILE__)."/"); // CHANGE TO HOSTING SUBFOLDER\PATH.
define("LIB","lib/"); // DEFINE PRIMARY LIBRARY PATH
define("IMAGES",LIB."images/");
define("CLASSES",LIB."classes/");
define("CSS",LIB."css/");
define("JS",LIB."js/");
define("_960",LIB."960/");
define("JQUERY",LIB."jquery/");
define("JQUERY_UI",JQUERY."jquery-ui/");
define("JQUERY_TOOLS",JQUERY."jquery-tools/");
define("JQUERY_VALIDATE",JQUERY."jquery-validate/");
define("SUPERFISH",JQUERY."superfish/");
define("JQUERY_PLACEHOLDER",JQUERY."jquery-placeholder/");
define("JQUERY_QRCODE",JQUERY."jquery-qrcode/");
define("JQUERY_LITE_ACCORDION",JQUERY."jquery-lite-accordion/");
define("JQUERY_NIVO_SLIDER",JQUERY."jquery-nivo-slider/");
define("JQUERY_ANYTHING_SLIDER",JQUERY."jquery-anything-slider/");
define("JQUERY_FLOWPLAYER",JQUERY."jquery-flowplayer/");
define("AJAX",LIB."ajax/");
define("TEMPLATES",LIB."templates/");
define("SETTINGS",LIB."settings/");
define("CACHE",LIB."cache/");

// DOCTYPE //
define("DOCTYPE","<!DOCTYPE HTML>\n"); // HTML 5

// SITE INFORMATION //
define("SITE_TITLE","[SITE TITLE]");
define("SITE_SLOGAN","[SITE SLOGAN]");
define("SITE_PRE",SITE_TITLE." | ");
define("LOGO",IMAGES."logo.png");
define("FAVICON","<link rel='shortcut icon' href='".IMAGES."favicon.png' type='image/png' />");
define("FAVICON_MOBILE","<link rel='apple-touch-icon' href='".IMAGES."favicon.png' />");
define("AUTHOR","A <a href='[AUTHOR URL]'>[AUTHOR]</a>");

// META DATA
$_metadata['charset'] = "<meta charset=\"utf-8\">";
$_metadata['description'] = "<meta name=\"description\" content=\"[META DESCRIPTION]\">";
$_metadata['keywords'] = "<meta name=\"keywords\" content=\"[META KEYWORDS]\">"; // COMMA DELIMITED
$_metadata['viewport'] = "<meta name=\"viewport\" content=\"width=device-width, initial-scale=0.8, maximum-scale=1.5\">"; // FOR MOBILE VIEWPORTS

// FRAMEWORK OPTIONS //
$enable_jquery = true;
$enable_validation = true; // REQUIRES JQUERY
$enable_jquery_ui = true; // REQUIRES JQUERY
$enable_jquery_tools = false; // REQUIRES JQUERY
$enable_jquery_placeholder = false; // REQUIRES JQUERY
$enable_jquery_qrcode = false; // REQUIRES JQUERY
$enable_jquery_lite_accordion = false; // REQUIRES JQUERY
$enable_jquery_nivo_slider = true; // REQUIRES JQUERY
$enable_jquery_anything_slider = false; // REQUIRES JQUERY
$enable_jquery_flowplayer = false; // REQUIRES JQUERY
$enable_video_js = true;
$enable_ckeditor = false;
$enable_960 = true;
$enable_superfish = false; // REQUIRES JQUERY
$enable_compression = true;
$enable_cache = false;
$enable_phpcss = true;
$enable_js_constants = false;

// SITE-WIDE //
//
require(SETTINGS."db.php");
require(SETTINGS."ftp.php");
require(SETTINGS."upload_options.php");
require(SETTINGS."backup_options.php");
require(CLASSES."class.standards.php");
require(CLASSES."class.form.php");
require(CLASSES."class.image.php");
require(CLASSES."class.misc.php");
require(CLASSES."class.database.php");
require(CLASSES."class.security.php");
require(CLASSES."class.backup.php");
if($enable_cache) { require(CLASSES."class.performance.php"); }
require(CLASSES."class.main.php");
require(CLASSES."class.css.php");
$main = new main();

// INITIALIZE SESSION
require(CLASSES."class.session.php");
session_start();
if(!isset($_SESSION['user'])) {
	$_SESSION['user'] = new session();
}

// HELPERS
$style_pre = "<link rel='stylesheet' type='text/css' href='";
$style_post = "' />";
$script_pre = "<script type='text/javascript' src='";
$script_post = "'></script>";
$style_pre_screen = "<link rel='stylesheet' media='screen' href='";
$style_post_screen = "' />";
define("SELECTED","selected='selected'");

// JQUERY
$_jquery['main'] = JQUERY."jquery-1.7.1.min.js";
$_jquery['ui']['main'] = JQUERY_UI."js/jquery-ui-1.8.16.custom.min.js";
$_jquery['ui']['theme'] = "ui-lightness";
$_jquery['ui']['theme_path'] = JQUERY_UI."css/".$_jquery['ui']['theme']."/jquery-ui-1.8.16.custom.css";
$_jquery['superfish']['main'] = SUPERFISH."js/superfish.js";
$_jquery['superfish']['css'] = SUPERFISH."css/superfish.css";
$_jquery['tools']['main'] = JQUERY_TOOLS."jquery.tools.min.js";
$_jquery['validate']['main'] = JQUERY_VALIDATE."jquery.validationEngine.js";
$_jquery['validate']['css'] = JQUERY_VALIDATE."validationEngine.jquery.css";
$_jquery['placeholder']['main'] = JQUERY_PLACEHOLDER."jquery.placeholder.min.js";
$_jquery['qrcode']['main'] = JQUERY_QRCODE."jquery.qrcode.min.js";
$_jquery['lite-accordion']['main'] = JQUERY_LITE_ACCORDION."js/liteaccordion.jquery.js";
$_jquery['lite-accordion']['css'] = JQUERY_LITE_ACCORDION."css/liteaccordion.css";
$_jquery['nivo-slider']['main'] = JQUERY_NIVO_SLIDER."jquery.nivo.slider.pack.js";
$_jquery['nivo-slider']['css'] = JQUERY_NIVO_SLIDER."nivo-slider.css";
$_jquery['anything-slider']['main'] = JQUERY_ANYTHING_SLIDER."js/jquery.anythingslider.js";
$_jquery['anything-slider']['easing'] = JQUERY_ANYTHING_SLIDER."js/jquery.easing.1.2.js";
$_jquery['anything-slider']['css'] = JQUERY_ANYTHING_SLIDER."css/anythingslider.css";
$_jquery['flowplayer']['main'] = JQUERY_FLOWPLAYER."flowplayer-3.2.6.min.js";
$_jquery['flowplayer']['swf'] = JQUERY_FLOWPLAYER."flowplayer-3.2.7.swf";

// JAVASCRIPT MISC
$_js['head'] = JS."head.min.js";
$_js['auto_complete'] = JS."auto_complete.js";
$_js['video_js']['main'] = JS."video-js/video.min.js";
$_js['video_js']['css'] = JS."video-js/video-js.min.css";
$_js['ckeditor']['main'] = LIB."ckeditor/ckeditor.js";

// 960
$_960['reset'] = _960."code/css/reset.css";
$_960['text'] = _960."code/css/text.css";
$_960['main'] = _960."code/css/960.css";
//$_960['main_24'] = _960."code/css/960_24_col.css"; // UNCOMMENT IF USING 24 COLUMN GRID


// COMPRESSION ELEMENTS
//
$_compress['css'] = array();
$_compress['js'] = array();
// 960 CSS MUST BE FIRST IN DECLARATION
if($enable_960) {
	$_compress['css'][] = $_960['reset'];
	$_compress['css'][] = $_960['text'];
	$_compress['css'][] = $_960['main'];
}
if($enable_jquery) { $_compress['js'][] = $_jquery['main']; }
if($enable_validation) {
	$_compress['js'][] = $_jquery['validate']['main'];
	$_compress['css'][] = $_jquery['validate']['css'];
}
if($enable_jquery_ui) {
	$_compress['css'][] = $_jquery['ui']['theme_path'];
	$_compress['js'][] = $_jquery['ui']['main'];
}
if($enable_jquery_tools) { $_compress['js'][] = $_jquery['tools']['main']; }
if($enable_superfish) {
	$_compress['css'][] = $_jquery['superfish']['css'];
	$_compress['js'][] = $_jquery['superfish']['main'];
}
if($enable_jquery_placeholder) { $_compress['js'][] = $_jquery['placeholder']['main']; }
if($enable_jquery_qrcode) { $_compress['js'][] = $_jquery['qrcode']['main']; }
if($enable_jquery_lite_accordion) {
	$_compress['css'][] = $_jquery['lite-accordion']['css'];
	$_compress['js'][] = $_jquery['lite-accordion']['main'];
}
if($enable_jquery_nivo_slider) {
	$_compress['css'][] = $_jquery['nivo-slider']['css'];
	$_compress['js'][] = $_jquery['nivo-slider']['main'];
}
if($enable_jquery_anything_slider) {
	$_compress['css'][] = $_jquery['anything-slider']['css'];
	$_compress['js'][] = $_jquery['anything-slider']['easing'];
	$_compress['js'][] = $_jquery['anything-slider']['main'];
}
if($enable_jquery_flowplayer) {
	$_compress['js'][] = $_jquery['flowplayer']['main'];
}
if($enable_video_js) {
	$_compress['js'][] = $_js['video_js']['main'];
	$_compress['css'][] = $_js['video_js']['css'];
}

// CUSTOM CSS MUST BE LAST IN DECLARATION
$_stylesheet['custom'] = css::load_css(BASEPATH.CSS); // LOADS CSS FILES FROM CSS DIR
$_stylesheet['ie'] = CSS."ie/ie.css";
$_stylesheet['ie6'] = CSS."ie/ie6.css";
$_stylesheet['ie7'] = CSS."ie/ie7.css";
$_stylesheet['ie8'] = CSS."ie/ie8.css";
$_stylesheet['ie9'] = CSS."ie/ie9.css";
foreach($_stylesheet['custom'] as $key=>$value) {
	$_compress['css'][] = $value;
}
$_compress['js'][] = $_js['head'];

// GENERATE JS TO SET DEFINED PHP VARIABLES WITHIN JS
if($enable_js_constants) {
	$constants = get_defined_constants(true);
	$js_constants = "";
	foreach($constants['user'] as $key=>$value) {
		$value = addslashes(str_replace("\n","",$value));
		$js_constants .= "var {$key} = \"{$value}\";";
	}
}
?>