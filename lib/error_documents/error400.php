<?PHP
define("PAGE_TITLE","Error 400");
require("../../config.php");
require(BASEPATH."header.php");
?>

<section id="main">
	<div class="grid_16">
		<div class="error">
			That's not a valid request. Please try again.
		</div>
	</div>
	<div class="clear"></div>
</section>

<?PHP require(BASEPATH."footer.php"); ?>