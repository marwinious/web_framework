<!-- SAMPLE HTML FORM TO BE USED WITH AJAX.UPLOADER.PHP -->
<form method="post" action="lib/ajax/ajax.uploader.php" enctype="multipart/form-data" target="upload_target" id="form_upload">

File: <input type="file" name="file1" />< <br />

<input type="submit" value="Upload file" />

<iframe src="#" frameborder="0" id="upload_target" name="upload_target" style="width:0;height:0;border:none;"></iframe>

<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#form_upload").submit(function() {
		// SHOW LOADING IMAGE/TEXT, ETC.
	});
});

function stopUpload(success){
	var result = '';
	if (success == 1){
		result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
	}
	else {
		result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
	}
	alert(result);
	return true;
}
// -->
</script>