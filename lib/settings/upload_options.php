<?PHP
// FILE UPLOAD OPTIONS //
//
// USE THIS VARIABLE TO RESTRICT A SMALL NUMBER OF MIME TYPES
$restricted_file_types = array("image/gif", "image/jpeg", "image/pjpeg");
// USE THIS VARIABLE TO ALLOW A SMALL NUMBER OF MIME TYPES
$accepted_file_types = array("application/msword", "application/vnd.ms-powerpoint", "application/vnd.ms-excel");
// USE THIS VARIABLE TO CONTROL MAX FILE SIZE LIMIT, IN BYTES (I.E. 2000000 = 2MB)
$max_file_size = 2000000;
// SPECIFY RESTRICTION OPTION
$use_restriction_type = "Restricted"; // OPTIONS: "Restricted", "Accepted", "" (ALLOW ALL)
// SPECIFY UPLOAD DIRECTORY
$upload_directory = "../../uploads/";
// SPECIFY CONFIRMATION/COMPLETION REDIRECT PAGE
$upload_redirect = "../../index.php";
?>