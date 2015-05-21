<?php

/*
 *	img_resize()
 *	
 *	Copyright (c) 2015 Brett Whiteman
 *	
 *	Function for resizing images on the fly in WordPress with resized image caching.
 */

if(!function_exists('img_resize')) {
	function img_resize($imageURL, $width, $height, $crop = false) {
		$imageBase = str_replace(basename($imageURL), '', $imageURL);
		$imageURL = parse_url($imageURL);
		$imagePath = $_SERVER['DOCUMENT_ROOT'] . $imageURL['path'];

		if (!file_exists($imagePath))
			return false;

		$originalSize = getimagesize($imagePath);

		if ($originalSize[0] <= $width)
			return $imageURL;

		if (!$height)
			$height = round($originalSize[1] / $originalSize[0] * $width);

		$pathInfo = pathinfo($imagePath);
		$resizedImageFileName = $pathInfo['filename'] . '-' . $width . 'x' . $height . '.' . $pathInfo['extension'];
		$resizedImageURL = $imageBase . $resizedImageFileName;
		$resizedImagePath = $pathInfo['dirname'] . '/' . $resizedImageFileName;

		if (file_exists($resizedImagePath))
			return $resizedImageURL;

		$editor = wp_get_image_editor($imagePath);

		if (is_wp_error($editor))
			return false;

		$editor->resize($width, $height, $crop ? array('center', 'center') : false);
		$editor->save($resizedImagePath);

		return $resizedImageURL;
	}
}
