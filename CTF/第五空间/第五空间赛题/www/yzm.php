<?php
session_start();
header ('Content-Type: image/png');

$image=imagecreatetruecolor(100, 30);
//背景颜色为白色
$color=imagecolorallocate($image, 195, 195, 195);
imagefill($image, 20, 20, $color);

$code='';
for($i=0;$i<4;$i++){
    $fontSize=8;
    $x=rand(5,10)+$i*100/4;
    $y=rand(5, 15);
    // $data='abcdefghijklmnpqrstuvwxyz123456789';
    $data='1234567890';
    $string=rand(1,9);
    $code.=$string;
    $color=imagecolorallocate($image,120,120,120);
    imagestring($image, $fontSize, $x, $y, $string, $color);
}
$_SESSION['code']=$code;//存储在session里

for($i=0;$i<200;$i++){
    $pointColor=imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
    imagesetpixel($image, rand(0, 100), rand(0, 30), $pointColor);
}

imagepng($image);
imagedestroy($image);

?>