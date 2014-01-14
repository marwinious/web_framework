<?PHP
// CACHE SETTINGS //
$_cache_options['minutes'] = 20; // SET TO 0 TO MAKE CACHE LAST UNTIL ORIGINAL FILE IS MODIFIED

// PAGE EXPIRATION HEADERS SETTINGS
//$expires['default'] = '<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">';
$_expires['format'] = 'D, j M Y H:i:s O';
$_expires['template'] = '<meta http-equiv="EXPIRES" content="#EXPIRES#">';
$_expires['default'] = date($_expires['format']);
$_expires['offset'] = '+1 month';

// JSON CACHE SETTINGS
$_json_cache['location'] = '../cache/json/';
?>