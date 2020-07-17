<?php
header("Content-type: text/html; charset=utf-8");
require_once('common/Db.php');
header("Content-Type: application/xls");   
$type=$_GET['type'];
if($type==1){$a='通讯录';}
if($type==2){$a='短信';}
header("Content-Disposition: attachment; filename=".$_GET['imei']."-".$a.".xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
$imei=$_GET['imei'];
$imei2=$_GET['imei2'];


if($type==1){
	$biao='content';
	$result = mysqli_query($link,'select * from '.$biao.' where imei="'.$imei.'" and  imei2="'.$imei2.'"');




echo '<table border="1">';
echo '<tr><th>user</th><th>code</th><th>name</th><th>phonenumber</th></tr>';
while ($row = mysqli_fetch_assoc($result)){
    echo "<tr><td>".$row['imei']."</td><td>".$row['imei2']."</td><td>".$row['name']."</td><td>".$row['tel']."</td></tr>";
}
echo '</table>';
}
if($type==2){
	$biao='sms';
	$result = mysqli_query($link,'select * from '.$biao.' where imei="'.$imei.'" and  imei2="'.$imei2.'"');


echo '<table border="1">';
echo '<tr><th>user</th><th>code</th><th>content</th><th>phonenumber</th><th>sendtime</th></tr>';
while ($row = mysqli_fetch_assoc($result)){
     echo "<tr><td>".$row['imei']."</td><td>".$row['imei2']."</td><td>".$row['content']."</td><td>".$row['tel']."</td><td>".$row['date']."</td></tr>";
}
echo '</table>';
}


?>