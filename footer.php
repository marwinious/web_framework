
<footer>
	
</footer>

<?PHP if($enable['960']) { echo "</div><!-- CLOSE 960 PRIMARY CONTAINER -->"; }?>
<?PHP if($enable['foundation_grid']) { echo "</div><!-- CLOSE FOUNDATION PRIMARY COLUMN -->\n</div><!-- CLOSE FOUNDATION PRIMARY ROW -->\n</div><!-- CLOSE FOUNDATION PRIMARY CONTAINER -->"; }?>

<script type="text/javascript">
<!--
$(document).ready(function() {
	$(".close_overlay").live("click",function() {
		$("#mask, .overlay").fadeOut(500);
	});
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
	if(!$cache_loaded) { performance::cache_save(PAGE_TITLE,$cache_options); }
}
?>