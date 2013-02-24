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
define("MEDIA","media/");
define("FOUNDATION_GRID",LIB."foundation_grid/");
define("JQUERY",LIB."jquery/");
define("JQUERY_UI",JQUERY."jquery-ui/");
define("JQUERY_TOOLS",JQUERY."jquery-tools/");
define("JQUERY_VALIDATE",JQUERY."jquery-validate/");
define("JQUERY_OVERLAY",JQUERY."jquery-overlay/");
define("SUPERFISH",JQUERY."superfish/");
define("JQUERY_PLACEHOLDER",JQUERY."jquery-placeholder/");
define("JQUERY_QRCODE",JQUERY."jquery-qrcode/");
define("JQUERY_LITE_ACCORDION",JQUERY."jquery-lite-accordion/");
define("JQUERY_NIVO_SLIDER",JQUERY."jquery-nivo-slider/");
define("JQUERY_ANYTHING_SLIDER",JQUERY."jquery-anything-slider/");
define("JQUERY_FLOWPLAYER",JQUERY."jquery-flowplayer/");
define("JQUERY_MEDIAELEMENT",JQUERY."jquery-mediaelement/");
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
$_metadata['charset'] = "<meta charset=\"UTF-8\">";
$_metadata['description'] = "<meta name=\"description\" content=\"[META DESCRIPTION]\">";
$_metadata['keywords'] = "<meta name=\"keywords\" content=\"[META KEYWORDS]\">"; // COMMA DELIMITED
$_metadata['viewport'] = "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=2.0\">"; // FOR MOBILE VIEWPORTS

// FRAMEWORK OPTIONS //
$enable['compression'] = true; // CHANGE TO TRUE FOR PRODUCTION ENVIRONMENT
$enable['core'] = true; // TOGGLE CORE STYLESHEETS
$enable['phpcss'] = true; // TOGGLE PHP-ENABLED STYLESHEETS
$enable['960'] = false; // TOGGLE 960gs GRID
$enable['foundation_grid'] = true; // TOGGLE FOUNDATION GRID
$enable['jquery'] = true;
$enable['validate'] = true; // REQUIRES JQUERY
$enable['overlay'] = true; // REQUIRES JQUERY
$enable['ui'] = true; // REQUIRES JQUERY
$enable['tools'] = false; // REQUIRES JQUERY
$enable['placeholder'] = false; // REQUIRES JQUERY
$enable['qrcode'] = false; // REQUIRES JQUERY
$enable['lite_accordion'] = false; // REQUIRES JQUERY
$enable['nivo_slider'] = true; // REQUIRES JQUERY
$enable['anything_slider'] = false; // REQUIRES JQUERY
$enable['flowplayer'] = false; // REQUIRES JQUERY
$enable['mediaelement'] = false; // REQUIRES JQUERY
$enable['scrollto'] = true; // REQUIRES JQUERY
$enable['video_js'] = false;
$enable['ckeditor'] = false;
$enable['superfish'] = false; // REQUIRES JQUERY
$enable['cache'] = false;
$enable['head'] = true;
$enable['auto_complete'] = false;
$enable['misc'] = true;
$enable['js_constants'] = false;
$enable['tinymce'] = false;

// SITE-WIDE //
//
require(SETTINGS."db.php"); // DATABASE SETTINGS
require(SETTINGS."ftp.php"); // FTP SETTINGS
require(SETTINGS."upload_options.php"); // UPLOAD OPTIONS
require(SETTINGS."backup_options.php"); // DATABASE BACKUP OPTIONS
require(SETTINGS."cache_options.php"); // CACHE OPTIONS
require(CLASSES."class.standards.php");
require(CLASSES."class.form.php");
require(CLASSES."class.image.php");
require(CLASSES."class.loader.php");
require(CLASSES."class.misc.php");
require(CLASSES."class.database.php");
require(CLASSES."class.security.php");
require(CLASSES."class.backup.php");
if($enable['cache']) { require(CLASSES."class.performance.php"); }
require(CLASSES."class.main.php");
require(CLASSES."class.css.php");
require(CLASSES."class.imaging.php");
$main = new main();

// INITIALIZE SESSION
require(CLASSES."class.session.php");
session_start();
if(!isset($_SESSION['user'])) {
	$_SESSION['user'] = new session();
}

// HELPERS
define("SELECTED","selected='selected'");

// JQUERY
$_load['jquery']['ver'] = "1.7.2";
$_load['jquery']['main'] = JQUERY."jquery-{$_load['jquery']['ver']}.min.js";
$_load['ui']['ver'] = "1.8.21";
$_load['ui']['main'] = JQUERY_UI."js/jquery-ui-{$_load['ui']['ver']}.custom.min.js";
$_load['ui']['theme'] = "ui-lightness";
$_load['ui']['theme_path'] = JQUERY_UI."css/".$_load['ui']['theme']."/jquery-ui-{$_load['ui']['ver']}.custom.css";
$_load['superfish']['main'] = SUPERFISH."js/superfish.js";
$_load['superfish']['css'] = SUPERFISH."css/superfish.css";
$_load['tools']['main'] = JQUERY_TOOLS."jquery.tools.min.js";
$_load['validate']['main'] = JQUERY_VALIDATE."jquery.validateInputDB.js";
$_load['overlay']['main'] = JQUERY_OVERLAY."jquery.overlay.js";
$_load['placeholder']['main'] = JQUERY_PLACEHOLDER."jquery.placeholder.min.js";
$_load['qrcode']['main'] = JQUERY_QRCODE."jquery.qrcode.min.js";
$_load['lite_accordion']['main'] = JQUERY_LITE_ACCORDION."js/liteaccordion.jquery.js";
$_load['lite_accordion']['css'] = JQUERY_LITE_ACCORDION."css/liteaccordion.css";
$_load['nivo_slider']['main'] = JQUERY_NIVO_SLIDER."jquery.nivo.slider.js";
$_load['nivo_slider']['css'] = JQUERY_NIVO_SLIDER."nivo-slider.css";
$_load['anything_slider']['main'] = JQUERY_ANYTHING_SLIDER."js/jquery.anythingslider.js";
$_load['anything_slider']['easing'] = JQUERY_ANYTHING_SLIDER."js/jquery.easing.1.2.js";
$_load['anything_slider']['css'] = JQUERY_ANYTHING_SLIDER."css/anythingslider.css";
$_load['flowplayer']['main'] = JQUERY_FLOWPLAYER."flowplayer-3.2.6.min.js";
$_load['flowplayer']['swf'] = JQUERY_FLOWPLAYER."flowplayer-3.2.7.swf";
$_load['mediaelement']['main'] = JQUERY_MEDIAELEMENT."build/mediaelement-and-player.min.js";
$_load['mediaelement']['css'] = JQUERY_MEDIAELEMENT."build/mediaelementplayer.min.css";
$_load['scrollto']['main'] = JQUERY."jquery-scrollto/jquery.scrollTo-1.4.3-min.js";

// JAVASCRIPT MISC
$_load['head'] = JS."head.min.js";
$_load['auto_complete'] = JS."auto_complete.js";
$_load['video_js']['main'] = JS."video-js/video.min.js";
$_load['video_js']['css'] = JS."video-js/video-js.min.css";
$_load['ckeditor']['main'] = LIB."ckeditor/ckeditor.js";
$_load['misc']['main'] = JS."functions_misc.js";
$_load['tinymce']['main'] = JS."tinymce/jscripts/tiny_mce/tiny_mce.js";

// 960
$_load['960']['main'] = _960."code/css/960.css";
//$_load['960']['main_24'] = _960."code/css/960_24_col.css"; // UNCOMMENT IF USING 24 COLUMN GRID

// FOUNDATION GRID
$_load['foundation_grid']['main'] = FOUNDATION_GRID.'foundation.min.css';

// CUSTOM CSS MUST BE LAST IN DECLARATION
if($enable['phpcss']) { $ext = 'php'; }
else { $ext = 'css'; }
$_stylesheet['core']['resets'] = CSS.'core_resets.css';
$_stylesheet['core']['normalize'] = CSS.'core_normalize.css';
$_stylesheet['core']['presets'] = CSS.'core_presets.'.$ext;
$_stylesheet['core']['fonts'] = CSS.'core_fonts.'.$ext;
$_stylesheet['core']['styles'] = CSS.'core_styles.'.$ext;
$_stylesheet['core']['print'] = CSS.'core_print.'.$ext;
$_stylesheet['ie']['all'] = CSS."ie/ie.css";
$_stylesheet['ie']['6'] = CSS."ie/ie6.css";
$_stylesheet['ie']['7'] = CSS."ie/ie7.css";
$_stylesheet['ie']['8'] = CSS."ie/ie8.css";
$_stylesheet['ie']['9'] = CSS."ie/ie9.css";

// GENERATE JS TO SET DEFINED PHP VARIABLES WITHIN JS
if($enable['js_constants']) {
	$constants = get_defined_constants(true);
	$js_constants = "";
	foreach($constants['user'] as $key=>$value) {
		$value = addslashes(str_replace("\n","",$value));
		$js_constants .= "var {$key} = \"{$value}\";";
	}
}
?>