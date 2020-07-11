<?php
	function imgcompress($src, $saveName) {
		list($width, $height, $type, $attr) = getimagesize($src);
		$imageinfo = array(
			'width' => $width,
			'height' => $height,
			'type' => image_type_to_extension($type, False),
			'attr' => $attr
		);
		$fun = 'imagecreatefrom' . $imageinfo['type'];
		$image = $fun($src);
		$new_width = 304.75;
		$new_height = $imageinfo['height'] * 304.75 / $imageinfo['width'];
		$image_thump = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($image_thump, $image, 0, 0, 0, 0, $new_width, $new_height, $imageinfo['width'], $imageinfo['height']);
		imagejpeg($image_thump, $saveName . '.jpeg');
	}
?>