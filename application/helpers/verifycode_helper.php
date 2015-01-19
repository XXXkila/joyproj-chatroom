<?php

function verify_test() {
	
	echo "hello world";
}

function create_verifycode() {
	session_start();
	
	$code = '';
	for ($i = 0; $i < 4; $i++) {
		$code .= mt_rand(0, 9);
	}
	$_SESSION['verifycode'] = $code;
	
	$width  = 150;		// 布画宽度
	$height = 45;		// 布画高度
	
	$image = imagecreate($width, $height); 
	imagecolorallocate($image, 240, 240, 240);
	
	$colors[] = imagecolorallocate($image, 0x42, 0x8b, 0xca);
	$colors[] = imagecolorallocate($image, 0x5c, 0xb8, 0x5c);
	$colors[] = imagecolorallocate($image, 0x5b, 0xc0, 0xde);
	$colors[] = imagecolorallocate($image, 0xf0, 0xad, 0x4e);
	$colors[] = imagecolorallocate($image, 0xd9, 0x53, 0x4f);
	
	$fontfile = dirname(__FILE__) . '/font.ttf';
	
	for ($i = 0; $i < strlen($code); $i++) {
		imagettftext($image, 30, mt_rand(-30, 30), 20 + 30 * $i, 35, $colors[array_rand($colors)], $fontfile, $code[$i]);
	}
	
	header('Content-Type: image/png');
	imagepng($image);
	
	imagedestroy($image);
}

function check_verifycode($code, $reset = true) {
	session_start();
	if (!isset($_SESSION['verifycode'])) {
		return false;
	}
	$bool = ($code == $_SESSION['verifycode']);
	if ($reset) {
		unset($_SESSION['verifycode']);
	}
	return $bool;
}