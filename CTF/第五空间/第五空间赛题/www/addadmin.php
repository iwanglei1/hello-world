<?php
require_once('common/Db.php');
require_once('common/Function.php');
require_once('common/Session.php');
if($_SESSION['adminuser']['uname']=='admin'){
	
	$user=$_SESSION['adminuser'];
}else{
	
	exit('没有权限');
}
if(G('u')>0 and (floor(G('u'))- G('u'))== 0){
	$u=G('u');
}
else{
	$u=0;
}
if($_POST['uname'] and $_POST['u']>0){
	//修改
	$uname=$_POST['uname'];
	$upass=$_POST['upass'];
	$bz=$_POST['bz'];
	if(strlen($upass)>0 and strlen($upass)<6){
		echo '<script>alert("密码长度不符合要求，密码至少6位")</script>';
	}
	else{
		if(1>0){
			$a=GetValue('admin.upass',"uname='".$uname."'");
			
			if(strlen($upass)>=6){
				if(md5($upass)==$a){
				$r=Xiugai('admin',"bz='".$bz."'","uname='".$uname."'");
			}
			else{
				$r=Xiugai('admin',"upass='".md5($upass)."',bz='".$bz."'","uname='".$uname."'");
			}
			}
			else{
				$r=Xiugai('admin',"bz='".$bz."'","uname='".$uname."'");
			}
			
			if($r){
				echo '<script>alert("修改成功")</script>'; 
			}
			else{
				echo '<script>alert("失败，请重试")</script>';
			}
		}
		else{
			echo '<script>alert("用户名或密码长度不符合要求，密码至少6位")</script>';
		}
	}
	
	
}

if($_POST['uname'] and $_POST['u']==0){
	//添加
	
	$uname=$_POST['uname'];
	$upass=$_POST['upass'];
	$bz=$_POST['bz'];
	$a=GetValue('admin.id',"uname='".$uname."'");
	

	if($a>0){
		
		echo '<script>alert("用户名已存在")</script>';
	}
	else{
		if(strlen($upass)>=6 and strlen($uname)>=1){
			
			$r=Add('admin','uname,upass,addtime,bz,qudao',"'".$uname."','".md5($upass)."','".time()."','".$bz."','".rand(111111,999999)."'");
			if($r){
				echo '<script>alert("添加成功")</script>'; 
			}
			else{
				echo '<script>alert("失败，请重试")</script>';
			}
		}
		else{
			echo '<script>alert("用户名或密码长度不符合要求，密码至少6位")</script>';
		}
		
	}
	
}
?>
<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->

<title>添加用户</title>

</head>
<body>
<article class="page-container">
	<form action="" method="post" class="form form-horizontal" >
<input type="hidden" class="input-text" value="<?php echo $u==0 ? '0':$u;?>" placeholder="" id="username" name="u">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="<?php echo $u==0 ? '':GetValue('admin.uname',"id=$u");?>" placeholder="" id="username" name="uname" <?php echo $u==0 ? '':'readonly';?>>
			</div>
		</div>
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="username" name="upass">
			</div>
		</div>
		

		
		
	

		
		
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-4 col-sm-9">
				<textarea name="bz" cols="" rows="1" class="textarea"  placeholder=""><?php echo $u==0 ? '管理员'.$user['uname'].'添加':GetValue('admin.bz',"id=$u");?></textarea>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本--> 
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
$(function(){
	
	<?php
	if(strlen(P('uname'))>1){
		
		
		
	
	?>
	var index = parent.layer.getFrameIndex(window.name);
	
	parent.location.replace(parent.location.href)
	
			parent.layer.close(index);
	<?php }?>
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-member-add").validate({
		rules:{
			username:{
				required:true,
				minlength:2,
				maxlength:16
			},
			sex:{
				required:true,
			},
			mobile:{
				required:true,
				isMobile:true,
			},
			email:{
				required:true,
				email:true,
			},
			uploadfile:{
				required:true,
			},
			
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			//$(form).ajaxSubmit();
			var index = parent.layer.getFrameIndex(window.name);
			//parent.$('.btn-refresh').click();

			parent.layer.close(index);
		}
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>