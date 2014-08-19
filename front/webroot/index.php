<?php
require_once('../config.php');
foreach (glob(_LIBS."/*.php") as $libs){
	require_once $libs;
}
foreach (glob(_MODS."/*.php") as $mods){
	require_once $mods;
}
foreach (glob(_SMARTY."/*.php") as $lib_smarty){
	require_once $lib_smarty;
}

$PHPSESSID = isset($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : null;
if($PHPSESSID) session_id($PHPSESSID);
session_start();
$sessionid = session_id();
setcookie('PHPSESSID', $sessionid, time()+31536000);

Templates::Assign('sessionid', $sessionid);

//---------------- 控制器
$uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : null;
if($uri){
	$uri = explode("/", $uri);
	$action = isset($uri[1]) ? $uri[1] : null;
	$action = explode("?", $action); 
	$action = isset($action[0]) ? $action[0] : null;
}
if($action){
	$action = $action.".php";
	$flag = 0;
	foreach (glob("*.php") as $webroot){
		if($action === $webroot){
			require_once $action;
			$flag = 1;
			exit;
		}
	}
	if(!$flag){
		header("Location: html/404.html");
		exit;
	}
}
//================================================= index 控制器
$organize = isset($_GET['o']) ? (int)$_GET['o'] : null;
$u = isset($_GET['u']) ? $_GET['u'] : null;
$from_url = isset($_GET['r']) ? $_GET['r'] : null;
$page = isset($_GET['p']) ? $_GET['p'] : 1;
if(!$organize){
	header("Content-type: text/html; charset=utf-8");
	exit("未获取到组织代码，请核对您的JS接口代码。");
}

$to_user = AdminUser::selectAStaffToCustomer($sessionid, $organize);
FrontUser::saveUser($sessionid, $to_user["username"], $organize, $u);

Templates::Assign('r', $from_url);
Templates::Assign('u', $u);
Templates::Assign('organize', $organize);
Templates::Assign('to_user', $to_user);
Templates::Display('index.tpl');



