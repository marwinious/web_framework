<?PHP
// INCLUDES
require("config.php");

// GET ERROR CODE
if($_GET['error_code']) {
	$error_code = $_GET['error_code'];
}

// SET PAGE TITLE
define("PAGE_TITLE","Error {$error_code}");

// HEADER
require("header.php");

// ERROR DOCUMENT
include(LIB.'error_documents/error'.$error_code.'.php');

// FOOTER
require("footer.php");
?>