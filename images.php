<?PHP
function debug($item) {
	echo "<pre>";print_r($item);echo "</pre>";
}

class imaging {
	
	function get_info($file) {
		$info = array();
		$info['path'] = pathinfo($file);
		$info['size'] = getimagesize($file);
		return $info;
	}
	
	function resize($image,$width='',$height='') {
		// INIT
		$source_image = imagecreatefromjpeg($image);
		if(empty($width)) { $width = '100%'; }
		if(empty($height)) { $height = '100%'; }
		
		// GET IMAGE INFO
		$info = $this->get_info($image);
		
		// GET RESIZE AMOUNT AND UNIT TYPE
		$regex = "/(\d+)(%|[A-Za-z]+)/";
		preg_match($regex,$width,$matches);
		$width_amount = $matches[1];
		$width_type = end($matches);
		preg_match($regex,$height,$matches);
		$height_amount = $matches[1];
		$height_type = end($matches);
		
		switch($width_type) {
			case '%':
				$new_width = floor($info['size'][0] * ($width_amount/100));
				break;
		}
		
		switch($height_type) {
			case '%':
				$new_height = floor($info['size'][1] * ($height_amount/100));
				break;
		}
		
		// CREATE IMAGE FOR PROCESSING
		switch($info['size']['mime']) {
			case 'image/jpeg':
				$new_image = imagecreatetruecolor($new_width,$new_height);
				break;
		}
		
		// RESIZE IMAGE
		$width = $info['size'][0];
		$height = $info['size'][1];
		imagecopyresized($new_image,$source_image,0,0,0,0,$new_width,$new_height,$width,$height);
		
		// EXPORT IMAGE
		$new_filename = $info['path']['filename'].'-'.$new_width.'x'.$new_height.'.jpg';
		imagejpeg($new_image,$new_filename);
		imagedestroy($new_image);
		debug($info);
		
		return $new_filename;
	}
	
}

$image = "mos-poster.jpg";
$imaging = new imaging();
$new_image = $imaging->resize($image,'25%','25%');
?>

New Image:<br />
<img src="<?PHP echo $new_image;?>" alt="" /><br />
<br />
Original Image: <br />
<img src="<?PHP echo $image;?>" alt="" /><br />

