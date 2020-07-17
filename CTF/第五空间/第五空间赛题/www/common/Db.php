<?php
/* 连接数据库服务器 */
$link = mysqli_connect(
    '127.0.0.1',  /* 连接MySQL地址 */
    'ctf',      /*连接MySQL用户名 */
    'this_is_password',  /* 连接MySQL密码 */
    'cms');    /*连接数据库名称*/

if (!$link) {
    printf("连接数据库出错，请联系维护人员: %s ", mysqli_connect_error());
    exit;
}
mysqli_query($link,'set names utf8');
?>