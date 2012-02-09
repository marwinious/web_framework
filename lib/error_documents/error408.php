<?PHP
define("PAGE_TITLE","Error 408");
require("../../config.php");
require(BASEPATH."header.php");
?>

<section id="main">
	<div class="grid_16">
		<div class="error">
			Your request has timed out on the server. Please click back and try again.
		</div>
	</div>
	<div class="clear"></div>
</section>

<?PHP require(BASEPATH."footer.php"); ?>