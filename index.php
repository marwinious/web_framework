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
	<?PHP misc::debug($_SERVER);?>
	
	<?PHP
	if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 9")) { echo "IE 9"; }
	if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8")) { echo "IE 8"; }
	if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 7")) { echo "IE 7"; }
	if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 6")) { echo "IE 6"; }
	?>
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