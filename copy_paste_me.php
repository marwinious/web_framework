<?PHP
define("PAGE_TITLE","Home");
require("config.php");

if($enable_cache) {
	// CHECK FOR CACHED PAGE
	$cache_loaded = false;
	if(performance::cache_load("index")) { $cache_loaded = true; exit();}
}

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
require("footer.php");

if($enable_cache) {
	// SAVE PAGE TO CACHE
	if(!$cache_loaded) { performance::cache_save("cache"); }
}
?>