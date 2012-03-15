<?PHP
// INCLUDES
require("config.php");

// CACHING, IF ENABLED
if($enable_cache) {
	// CHECK FOR CACHED PAGE
	$cache_loaded = false;
	if(performance::cache_load("index")) { $cache_loaded = true; exit();}
}

// PAGE TITLE
define("PAGE_TITLE","NEW PAGE");

// LOAD HEADER
require("header.php");
?>

<section id="main">
	
</section>

<script type="text/javascript">
<!--
$(document).ready(function() {
	
});
// -->
</script>

<?PHP 
// LOAD FOOTER
require("footer.php");

// CACHING, IF ENABLED
if($enable_cache) {
	// SAVE PAGE TO CACHE
	if(!$cache_loaded) { performance::cache_save("cache"); }
}
?>