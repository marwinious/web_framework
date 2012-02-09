<?PHP
define("PAGE_TITLE","Error 500");
require("../../config.php");
require(BASEPATH."header.php");
?>

<section id="main">
	<div class="grid_16">
		<div class="error">
			Well this is embarassing. An error has occured on the server. Please click back and try again.
		</div>
	</div>
	<div class="clear"></div>
</section>

<?PHP require(BASEPATH."footer.php"); ?>