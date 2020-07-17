<?php
require_once('common/Db.php');
require_once('common/Function.php');
require_once('common/Session.php');

$jingweidu=GetValues('mac.*',"imei='".G('i')."' and id>0 and imei2='".G('q')."'");
if($jingweidu['jingdu']>0 and $jingweidu['weidu']>0){}else{exit('未采集到位置信息');}

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<script type="text/javascript" src="//api.map.baidu.com/api?v=2.0&ak=lnTdedpeCtGGX5OUwWzULoOh"></script>
	<style type="text/css">
		body, html,#allmap {
			width: 100%;height: 100%;
			overflow: hidden;margin:0;
			font-family:"微软雅黑";
		}
	</style>
	<title>定位</title>
</head>
 
<body>
	<div id="allmap"></div>
	<div id="map-address0" style="display:none">
   		
	</div>

</body>
</html>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");    // 创建Map实例
	map.centerAndZoom(new BMap.Point(<?php echo $jingweidu['jingdu'];?>,<?php echo $jingweidu['weidu'];?>),15);  // 初始化地图,设置中心点坐标和地图级别
	//添加地图类型控件
	map.addControl(new BMap.MapTypeControl({
		mapTypes:[
            BMAP_NORMAL_MAP,
            BMAP_HYBRID_MAP
        ]}));	             			
	map.setCurrentCity("西安");          // 设置地图显示的城市 此项是必须设置的
	map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

	
	// 用经纬度设置地图中心点
	var longitude = <?php echo $jingweidu['jingdu'];?>;
	var latitude = <?php echo $jingweidu['weidu'];?>;
	if( longitude!=null && latitude != null){
		map.clearOverlays(); 
		var new_point = new BMap.Point(longitude,latitude);
		var infoWindow = new BMap.InfoWindow(document.getElementById("map-address0").innerHTML);
		var marker = new BMap.Marker(new_point);  // 创建标注
		//点击标注显示信息
		marker.addEventListener("click", function(){          
		    this.openInfoWindow(infoWindow);
		});
		map.addOverlay(marker);              // 将标注添加到地图中
		map.panTo(new_point);      
	}
</script>

