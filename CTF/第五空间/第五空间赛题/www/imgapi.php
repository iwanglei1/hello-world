<?php


$imageName = "tp_".$_POST['sjh'].$_POST['yqm'].'.jpg';
$path = "./tp";
$imageSrc= $path."/". $imageName;
$r = file_put_contents($imageSrc, base64_decode($_POST['data']));
if (!$r) {
 echo '验证失败';
}else{
echo '200';
}

?>