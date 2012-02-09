<?PHP
define("PAGE_TITLE","Error 403");
require("../../config.php");
require(BASEPATH."header.php");
?>

<section id="main">
	<div class="grid_16">
		<div class="error">
			You don't appear to have permission to view this page. Please try a different link.
		</div>
	</div>
	<div class="clear"></div>
</section>

<?PHP require(BASEPATH."footer.php"); ?>