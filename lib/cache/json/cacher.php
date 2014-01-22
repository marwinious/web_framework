<?PHP
/*
SCRIPT: CALL THIS FILE VIA URL/AJAX TO TRIGGER CACHING
AUTHOR: DARIUS BABCOCK
LAST UPDATED: 1/13/2014
SAMPLE URL TO SAVE CACHE: http://host.coxmediagroup.com/cop/digital/common/cache/cacher.php?saveas=whio_right_rail&json_url=https%3A%2F%2Fspreadsheets.google.com%2Ffeeds%2Flist%2F0AvZ8jb1VrdtNdDdFajZ2dExHR3ZXZThTeW83dnExS1E%2Fod6%2Fpublic%2Fvalues%3Falt%3Djson
OPTIONAL PARAMETERS: &max_cache_lifetime=15, &force_reload=true
*/

// SET HEADER TO ALLOW CROSS-DOMAIN REQUESTS
header('Access-Control-Allow-Origin: *');
header('Content-type: text/javascript');

require('../../../config.php');
require('../../classes/class.json_cacher.php');

if($_GET['saveas'] && $_GET['json_url']) {
	// INIT
	$filename = $_GET['saveas'];
	$json_url = $_GET['json_url'];
	$force_reload = 'false';
	$max_cache_lifetime = 15; // IN MINUTES
	$save_path = dirname(__FILE__).'/';
	$format = 'json';
	
	// SET FORCE_RELOAD, IF SPECIFIED
	if(isset($_GET['force_reload'])) {
		$force_reload = $_GET['force_reload'];
	}
	
	// SET MAX_CACHE LIFETIME, IF SPECIFIED
	if(isset($_GET['max_cache_lifetime'])) {
		$max_cache_lifetime = $_GET['max_cache_lifetime'];
	}
	
	// SET FORMAT, IF SPECIFIED
	if(isset($_GET['format'])) {
		$format = $_GET['format'];
	}

	// INSTANTIATE CACHER
	$cacher = new json_cacher($filename, $json_url, $max_cache_lifetime, $force_reload, $save_path, $format);
	// LOAD JSON FROM CACHE
	$cacher->load_cache();
}
else {
	echo "Error: Did not receive valid query string.";
}
?>