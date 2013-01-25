<?PHP
class imaging {
	
	function get_info($file) {
		$info = array();
		$info['path'] = pathinfo($file);
		$info['size'] = getimagesize($file);
		return $info;
	}
	
	function resize($image,$size,$measure) {
		// INIT
		$source_image = imagecreatefromjpeg($image);
		$quality = 100;
		
		// GET IMAGE INFO
		$info = $this->get_info($image);
		$source_width = $info['size'][0];
		$source_height = $info['size'][1];
		
		// DETERMINE SIZE BASED ON MEASURE TYPE
		switch($measure) {
			case 'px':
				$size = explode('x',$size);
				$new_width = $size[0];
				$new_height = $size[1];
				break;
			
			case 'pct':
				if(strpos($size,'x')) {
					$size = explode('x',$size);
					$quality = $size[1];
					$size = $size[0];
				}
				$size = $size/100;
				$new_width = $info['size'][0] * $size;
				$new_height = $info['size'][1] * $size;
				break;
		}
		if(empty($new_width)) { $new_width = $info['size'][0]; }
		if(empty($new_height)) { $new_height = $info['size'][1]; }
		
		// CREATE IMAGE FOR PROCESSING
		switch($info['size']['mime']) {
			case 'image/jpeg':
				$new_image = imagecreatetruecolor($new_width,$new_height);
				break;
		}
		
		// RESIZE IMAGE
		$width = $info['size'][0];
		$height = $info['size'][1];
		imagecopyresized($new_image,$source_image,0,0,0,0,$new_width,$new_height,$source_width,$source_height);
		
		// EXPORT IMAGE
		//$new_filename = $info['path']['filename'].'-'.$new_width.'x'.$new_height.'.jpg';
		$new_filename = imagejpeg($new_image,NULL,$quality);
		imagedestroy($new_image);
		
		return $new_filename;
	}
}
?>