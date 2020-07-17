<?php
session_start();
if($_SESSION['adminuser'] and is_array($_SESSION['adminuser']) and CheckUser($_SESSION['adminuser']['id'])){
	$_SESSION['adminuser'] = $_SESSION['adminuser'];
}
else{
	Tz('Login');
	
}
?>