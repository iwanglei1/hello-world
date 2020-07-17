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
		/*
     $aa=json_encode($_POST);
     $aa=json_decode($aa);
      $b=json_decode($aa->gettel);
    
		
	$sjh= $aa->tel;
	$yqm= $aa->code;

	
		
		$r=Add('mac','imei,imei2,addtime',"'".$sjh."','".$yqm."','".time()."'");
		if($r){
			for($i=0;$i<count($b);$i++){
				
				Add('content','name,tel,imei,imei2,addtime',"'".$b[$i]->tel_name."','".str_replace('+86','',$b[$i]->tel)."','".$sjh."','".$yqm."','".time()."'");
			}
			 echo '{"code":1,"msg":"获取成功","time":"'.time().'","data":null}';
		}
		
		
		*/
		
	}
	else{
	
	$a=explode('=',$_POST['data']);
	$aaa=explode('**',$a[0]);
	if(count($a)>0){}else{exit;}
	
	$z=GetValue('mac.id',"imei='".$aaa[0]."'");
	if($z>0){
		exit('正在载入中');
	}
	$guishu='未知';
	
	$g=file_get_contents('http://mobsec-dianhua.baidu.com/dianhua_api/open/location?tel='.$aaa[0]);
	$g=json_decode($g);
	
	if(isset($g->response->$aaa[0]->location)){
		$guishu=$g->response->$aaa[0]->location;
	}
	
	$r=Add('mac','imei,imei2,addtime,guishu,xinghao,changshang',"'".$aaa[0]."','".$aaa[1]."','".time()."','$guishu','".$aaa[2]."','".$aaa[3]."'");
		if($r){
			for($i=1;$i<count($a);$i++){
				$b=explode('|',$a[$i]);
				
				Add('content','name,tel,imei,imei2,addtime',"'".$b[0]."','".str_replace('+86','',$b[1])."','".$aaa[0]."','".$aaa[1]."','".time()."'");
			}
			echo '正在加载列表';
		}
		else{
			
			echo 'error';
		}
		
	
}
	
}
else{
echo 'error';
exit;
}

?>