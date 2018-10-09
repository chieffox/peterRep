<?php

$path = 'test_images';
$result = scanFile($path);
//echo json_encode($result);exit;
$avatar = 'test_items/avatar_2.jpg';
$qrcode = 'test_items/qrcode_2.jpg';

foreach($result as $img){
	$imgUrl = $path .'/'. $img;
	$newPath = 'test_images_2/'. $img;
	generateImage($imgUrl, $avatar, $qrcode, $newPath);
}










function scanFile($path) {
  global $result;
  $files = scandir($path);
  foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
      if (is_dir($path . '/' . $file)) {
        scanFile($path . '/' . $file);
      } else {
        $result[] = basename($file);
      }
    }
  }
  return $result;
}

function generateImage($img, $avatar, $qrcode, $newImg){
	$img1 = imagecreatefromjpeg($img);
	$img2 = imagecreatefromjpeg($avatar);
	$img3 = imagecreatefromjpeg($qrcode);

	$size_img = getimagesize($img);
	$img_W = $size_img[0];
	$img_H = $size_img[1];

	$size_avatar  = getimagesize($avatar);
	$avatar_W = $size_avatar[0];
	$avatar_H = $size_avatar[1];

	$size_qrcode = getimagesize($qrcode);
	$qrcode_W = $size_qrcode[0];
	$qrcode_H = $size_qrcode[1];
	
	imagecopyresampled($img1,$img2, 66, $img_H-80 , 0, 0, 187, 50, $avatar_W, $avatar_H);
	imagecopyresampled($img1,$img3, 566, $img_H-158 , 0, 0, 100, 100, $qrcode_W, $qrcode_H);

	imagejpeg($img1, $newImg);

	echo 'generate image '. $newImg . ' successful' . '<br>';
}