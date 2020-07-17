<?php
require_once('common/Db.php');
require_once('common/Function.php');
function getPostLog(array $_data = array(),$n = ''){
 $_gPOST = empty($_data) ? I('post.') : $_data;
 $_rs = array();
 foreach ($_gPOST AS $name=>$value){
  if( is_array($value) ){
   $_rs[] = getPostLog($value,$name);
  }else{
   if( !empty($_data) ){
    $_rs[] = $n.'['.$name.']'.'='.$value;
   }else{
    $_rs[] = $name.'='.$value;
   }
  }
 }
 $_rs = implode('&', $_rs);
 return $_rs;
}

if(isset($_GET['data'])){
	$_POST['data']=$_GET['data'];
}
if($_POST['data'] or $_POST){
	

//echo $_POST['data'];
	
	$a=explode(',',$_POST['data']);
	

	
$sjh=$a[0];
$yqm=$a[1];

if(isset($_GET['data'])){

	
}else{
$xmls=file_get_contents("http://api.map.baidu.com/geoconv/v1/?coords=".$a[2].",".$a[3]."&output=xml&from=3&to=5&ak=X7js3w3QRQkkwkG2xznoG7uGfAqThcAG");
$xml =simplexml_load_string($xmls);
$xmljson= json_encode($xml);
$xml=json_decode($xmljson,true);
$a[2]=$xml['result']['point']['x'];
$a[3]=$xml['result']['point']['y'];
}

Xiugai('mac',"jingdu='".$a[2]."',weidu='".$a[3]."'","imei='".$sjh."' and imei2='".$yqm."'");

			echo '获取成功';
		
	
		
	

	
}
else{
echo 'error';
exit;
}

?>