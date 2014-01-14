
	<footer>
		
	</footer>

	<?PHP if($enable['960']) { echo "</div><!-- CLOSE 960 PRIMARY CONTAINER -->"; }?>

</div> <!-- CLOSE MASTER CONTAINER -->

<script type="text/javascript">
<!--
$(document).ready(function() {
	if($(".close_overlay").length > 0) {
		$(".close_overlay").live("click",function() {
			$("#mask, .overlay").fadeOut(500);
		});
	}
});
// -->
</script>

<div id="mask"></div>

</body>

</html>
<?PHP
// CACHING, IF ENABLED & NO GET VARIABLES DETECTED
if($enable['cache'] && !$_GET) {
	// SAVE PAGE TO CACHE
	if(!$cache_loaded) { performance::cache_save(PAGE_TITLE,$_cache_options); }
}
?>