<?PHP
define("PAGE_TITLE","Error 401");
require("../../config.php");
require(BASEPATH."header.php");
?>

<section id="main">
	<div class="grid_16">
		<div class="error">
			That action does appear to be authorized at this time.
		</div>
	</div>
	<div class="clear"></div>
</section>

<?PHP require(BASEPATH."footer.php"); ?>