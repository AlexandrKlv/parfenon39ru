<?php

	session_start();

	// header('content-type: image/png');

	$xSize = 109;
	$ySize = 26;
	$charactersCount = 4;
	$fontsize = 22;

	$image = imagecreate($xSize, $ySize);

    $bgColor = imagecolorallocate($image, 240, 240, 240);
	$fontColor = imagecolorallocate($image, 0, 0, 0);   

	$font = 'fonts/CourierBold.ttf';

	$string = '';
	$characters = 'abcdefghijklmnopqrstuvwxyz';
	preg_match_all('/[a-z]/iu', $characters, $matches);
	shuffle($matches[0]);
	$sliceArr = array_slice($matches[0], 0, $charactersCount);
	$string = implode('', $sliceArr);
	foreach ($sliceArr as $key => $value) {
	    $x = ($xSize - 20) / $charactersCount * $key + 10;
	    $y = $ySize - (($ySize - $fontsize) * 2);    
	    $color = imagecolorallocate($image, rand(0, 200), rand(0, 200), rand(0, 200)); 
	    $naklon = rand(-30, 30); 
	    imagettftext($image, $fontsize, $naklon, $x, $y, $color, $font, $value);
	}

	$_SESSION['captcha'] = $string;

	imagepng($image);
 
 	imagedestroy($image);

?>
