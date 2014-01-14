<?PHP
// EXPECTED URL PATTERN
// FOR SOLID PIXEL DIMENSIONS
// lib/images/resize/px/(filename of image stored in media/images)/WIDTHxHEIGHT
// FOR PERCENT CHANGE
// lib/images/resize/pct/(filename of image stored in media/images)/PERCENT(1-100)xQUALITY(1-100)

// INCLUDES
require("../../../config.php");

// Content type
header('Content-Type: image/jpeg');

if($_GET) {
	$image = '../'.urldecode($_GET['image']);
	$size = $_GET['size'];
	$measure = $_GET['measure'];
	
	$imaging = new imaging();
	$new_image = $imaging->resize($image,$size,$measure);
	
	echo $new_image;
}
?>