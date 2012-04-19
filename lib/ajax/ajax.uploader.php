<?PHP
require("../../config.php");
require("../classes/class.uploader.php");

// SET FOLDER FOR UPLOAD
$destination_path = $upload_directory;

// UPLOAD
$uploader = new uploader();
$result = $uploader->upload2($_FILES,$destination_path);
?>
<script type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>);</script>