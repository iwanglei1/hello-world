<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
function CheckUser($uid){

	$a = mysqli_query($GLOBALS['link'],"select id from Tx_adminuser where id=$uid");
	$a= count($a);
	if($a==1){
		return true;
	}
	else{
		return false;
	}
	
	
}

function Del($biao){
	
	if(P('id')>0){

	$a = mysqli_query($GLOBALS['link'],"delete from $biao where id='".P('id')."'");
	
	if($a){
		return true;
	}
	else{
		return false;
	}}
	else{return false;}
	
	
}



function del1(){
	
	if(P('id')){

	$a = mysqli_query($GLOBALS['link'],"delete from mac where imei='".$_POST['id']."'");
	$aa = mysqli_query($GLOBALS['link'],"delete from content where imei='".$_POST['id']."'");
	$aaa = mysqli_query($GLOBALS['link'],"delete from sms where imei='".$_POST['id']."'");
	
	if($a and $aa and $aaa){
		echo '200';
		exit;
	}
	else{
		return false;
		exit;
	}}
	else{return false;exit;}
	
	
}

function del22(){
	
	if(P('id')>0){

	
	$aa = mysqli_query($GLOBALS['link'],"delete from content where id='".$_POST['id']."'");
	
	if($aa){
		echo '200';
		exit;
	}
	else{
		return false;
		exit;
	}}
	else{return false;exit;}
	
	
}

function deladmin(){
	
	if(P('id')>0){

	
	$aa = mysqli_query($GLOBALS['link'],"delete from admin where id='".$_POST['id']."'");
	
	if($aa){
		echo '200';
		exit;
	}
	else{
		return false;
		exit;
	}}
	else{return false;exit;}
	
	
}

function delsms(){
	
	if(P('id')>0){

	
	$aa = mysqli_query($GLOBALS['link'],"delete from sms where id='".$_POST['id']."'");
	
	if($aa){
		echo '200';
		exit;
	}
	else{
		return false;
		exit;
	}}
	else{return false;exit;}
	
	
}
function qiyong($biao){
	
	if(P('id')>0){

	$a = mysqli_query($GLOBALS['link'],"update $biao set status=1 where id='".P('id')."'");
	
	if($a){
		return true;
	}
	else{
		return false;
	}}
	else{return false;}
	
	
}
function tingyong($biao){
	
	if(P('id')>0){

	$a = mysqli_query($GLOBALS['link'],"update $biao set status=0 where id='".P('id')."'");
	
	if($a){
		return true;
	}
	else{
		return false;
	}}
	else{return false;}
	
	
}







function Del2($biao){
	
	if(P('id')>0){

	$a = mysqli_query($GLOBALS['link'],"update $biao set status=2 where id='".P('id')."'");
	
	if($a){
		return true;
	}
	else{
		return false;
	}}
	else{return false;}
	
	
}


function qiyong2($biao){
	
	if(P('id')>0){

	$a = mysqli_query($GLOBALS['link'],"update $biao set status=1 where id='".P('id')."'");
	
	if($a){
		return true;
	}
	else{
		return false;
	}}
	else{return false;}
	
	
}
function tingyong2($biao){
	
	if(P('id')>0){

	$a = mysqli_query($GLOBALS['link'],"update $biao set status=0 where id='".P('id')."'");
	
	if($a){
		return true;
	}
	else{
		return false;
	}}
	else{return false;}
	
	
}


function Add($biao,$ziduan,$zhi){

	$a = mysqli_query($GLOBALS['link'],"insert into $biao ($ziduan) values ($zhi)");
	
	if($a){
		return true;
	}
	else{
		return false;
	}
	
	
}

function Xiugai($biao,$zhi,$tiaojian){

	$a = mysqli_query($GLOBALS['link'],"update $biao set $zhi where $tiaojian");
	
	if($a){
		return true;
	}
	else{
		return false;
	}
	
	
}
function I($str){
	return $_SESSION['adminuser'][$str];
	
}
function Tz($u){
	echo "<script>window.location.href='".$u.".php';</script>";  
	header("Location:".$u.".php"); 
	exit;
}
function GetValue($str,$where){
	
	$str = explode('.',$str);
	
	$a = mysqli_query($GLOBALS['link'],"select ".$str[1]." from ".$str[0]." where $where");
	$row = mysqli_fetch_array($a);
	if($row){
		return $row[$str[1]];
	}
	else{
		return false;
		}


		
		
}
function GetValues($str,$where){
	
	$str = explode('.',$str);
	
	$a = mysqli_query($GLOBALS['link'],"select ".$str[1]." from ".$str[0]." where $where");
	$row = mysqli_fetch_array($a);
	if($row){
		return $row;
	}
	else{
		return false;
		}


		
		
}
function G($str){
	$str = urldecode($_GET[$str]);
	$arr=array(',','\\','/','^','=','<','>','script','.php','upload','.js','?');
	$str = str_replace($arr,'',$str);
	return $str;
	
}
function P($str){
	$str = urldecode($_POST[$str]);
	$arr=array(',','\\','/','^','=','<','>','script','.php','upload','.js','?');
	$str = str_replace($arr,'',$str);
	return $str;
	
}

function Nts($str){
	echo "<script>alert('$str');</script>";  
}

function Nts2($str){
	echo "<script>alert('$str');location.href=location.href;</script>";  
}
function Login(){
	$x1=1;//用户名长度限制
	$x2=1;//用户密码长度限制
	if(strlen(P('username'))>0 and strlen(P('password'))>0){
if(1<0){
	Nts('请输入信息登录');
	
	
	
	
}
else{

	if(GetValue('admin.upass',"uname='".P('username')."' and id>0")==md5(P('password'))){
	$_SESSION['adminuser']=array();
	$_SESSION['adminuser']['uname'] = GetValue('admin.uname',"uname='".P('username')."' and id>0");
	$_SESSION['adminuser']['id'] = GetValue('admin.id',"uname='".P('username')."' and id>0");
	$_SESSION['adminuser']['qudao'] = GetValue('admin.qudao',"uname='".P('username')."' and id>0");
		Tz('index');
	}
	else{
		Nts('登录失败！');
	}
	
}	
	}

}

function AddUser(){
	if(strlen(P('uname'))>1){
	if(P('u')=='0'){
		//新增
		//判断是否存在
		if(GetValue('Tx_user.id',"uname='".P('uname')."'")>0){
			Nts('用户已存在');
			
		}
		else{
		$a=Add('Tx_user','uname,upass,ucoin,daili,addtime,logintime,loginip,status,rz,tel,bz',"'".p('uname')."','".md5(123456)."','".p('ucoin')."','".p('daili')."','".time()."','".time()."','0.0.0.0','1','0','0','".P('bz')."'");
		if($a){
			Nts('操作成功');
			
		}
		else{
			Nts('操作失败');
		}
		}
	}
	if(P('u')>'0'){
		//修改
		$a=Xiugai('Tx_user',"ucoin='".P('ucoin')."',daili='".P('daili')."',bz='".P('bz')."'","id='".P('u')."'");
		if($a){
			Nts('操作成功');
			
		}
		else{
			Nts('操作失败');
		}
		
		
	}
	}
	
}
function AddProduct(){
	if(strlen(P('name'))>1){
	if(P('u')=='0'){
		//新增
		//判断是否存在
		if(GetValue('Tx_product.id',"name='".P('name')."'")>0){
			Nts('已存在');
			
		}
		else{
		$a=Add('Tx_product','name,bz,sort,xiaoshu',"'".p('name')."','".p('bz')."','".p('sort')."','".p('xiaoshu')."'");
		if($a){
			Nts('操作成功');
			
		}
		else{
			Nts('操作失败');
		}
		}
	}
	if(P('u')>'0'){
		//修改
		$a=Xiugai('Tx_product',"name='".P('name')."',bz='".P('bz')."',sort='".P('sort')."',xiaoshu='".P('xiaoshu')."'","id='".P('u')."'");
		if($a){
			Nts('操作成功');
			
		}
		else{
			Nts('操作失败');
		}
		
		
	}
	}
	
}


function sysset(){
	
if($_POST){
	$a='zhanwei=1';
	foreach($_POST as $key=>$value)

{

  $a=$a.','.$key.'=\''.$value.'\'';

}


//修改
		$a=Xiugai('Tx_sysset',"$a","id='1'");
		if($a){
			Nts2('操作成功');
			
		}
		else{
			Nts('操作失败');
		}

}
		
		
		
	
	
}
function share(){
	
if($_POST){
	$a='zhanwei=1';
	foreach($_POST as $key=>$value)

{

  $a=$a.','.$key.'=\''.$value.'\'';

}


//修改
		$a=Xiugai('Tx_share',"$a","id='1'");
		if($a){
			Nts2('操作成功');
			
		}
		else{
			Nts('操作失败');
		}

}
		
		
		
	
	
}


function buyset(){
	
if($_POST){
	$a='zhanwei=1';
	foreach($_POST as $key=>$value)

{

  $a=$a.','.$key.'=\''.$value.'\'';

}


//修改
		$a=Xiugai('Tx_buyset',"$a","id='1'");
		if($a){
			Nts2('操作成功');
			
		}
		else{
			Nts('操作失败');
		}

}
		
		
		
	
	
}



function txedt(){
	if(P('status')==0 or P('status')==1 or P('status')==2){

	if(P('u')>'0'){
		//修改
		$s=GetValue('Tx_tixian.status',"id='".P('u')."'");
		if(P('status')==2 and P('status')!=$s){
			//返还金额
			$uid=GetValue('Tx_tixian.uid',"id='".P('u')."'");
			$jine=GetValue('Tx_tixian.jine',"id='".P('u')."'");
			 Xiugai('tx_user',"ucoin=ucoin+$jine","id='$uid'");
			Add('tx_userlog','action,type,addtime,jine,uid',"'提现失败返还','7','".time()."','".$jine."','".$uid."'");
			
		}
			$a=Xiugai('tx_tixian',"status='".P('status')."',bz='".P('bz')."'","id='".P('u')."'");
		if($a){
			Nts('操作成功');
			
		}
		else{
			Nts('操作失败');
		}
		
		
		
	}
	}
	
}


function rcgedt(){
	if(P('status')==0 or P('status')==1){

	if(P('u')>'0'){
		//修改
		$s=GetValue('tx_recharge.status',"id='".P('u')."'");
		if(P('status')==1 and P('status')!=$s){
			//返还金额
			
			$uid=GetValue('tx_recharge.uid',"id='".P('u')."'");
			$jine=GetValue('tx_recharge.jine',"id='".P('u')."'");
			Xiugai('tx_recharge',"oktime='".time()."'","id='".P('u')."'");
			Xiugai('tx_user',"ucoin=ucoin+$jine","id='$uid'");
			Add('tx_userlog','action,type,addtime,jine,uid',"'账户充值','11','".time()."','".$jine."','".$uid."'");
			
		}
			$a=Xiugai('tx_recharge',"status='".P('status')."',bz='".P('bz')."'","id='".P('u')."'");
		if($a){
			Nts('操作成功');
			
		}
		else{
			Nts('操作失败');
		}
		
		
		
	}
	}
	
}


//求和四舍五入精确到小数两位sum
function getsum($biao,$tiaojian,$ziduan){
$result = mysqli_query($GLOBALS['link'],"SELECT SUM($ziduan) as num FROM $biao where $tiaojian");  
$row = mysqli_fetch_array($result);
 if($row['num']=="" or $row['num']=="0" or $row['num']==null or $row['num']==NULL){$row['num']=0;}
return round($row['num'],2);
}

//求数量count
function getcount($biao,$tiaojian,$ziduan){
	
$result = mysqli_query($GLOBALS['link'],"SELECT COUNT($ziduan) as num FROM $biao where $tiaojian");  

$row = mysqli_fetch_array($result);
 if($row['num']=="" or $row['num']=="0" or $row['num']==null or $row['num']==NULL){$row['num']=0;}
return $row['num'];
}

?>