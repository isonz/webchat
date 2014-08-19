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

//---------------- 安全控制
$_GET = Security::getRequest('request');
$_POST = Security::getRequest();

//---------------- 控制器
$uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : null;
if($uri){
	$uri = explode("/", $uri);
	$action = isset($uri[1]) ? $uri[1] : null;
	$action = explode("?", $action);
	$action = isset($action[0]) ? $action[0] : null;
}

//----------------- user
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
Templates::Assign('user', $user);
Templates::Assign('sessionid', $user);

if(!$user && !in_array($action, $GLOBALS['EXCLUDE_URL'])){
	require_once 'sign.php';
	exit;
}

if($action){
	$action = $action.".php";
	$flag = 0;
	foreach (glob("*.php") as $webroot){
		if($action === $webroot){
			require_once $action;
			exit;
		}
	}
	if(!$flag){
		header("Location: html/404.html");
		exit;
	}
}
//================================================= index 控制器
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
switch ($type){
	case 'update':
		$key = isset($_REQUEST['key']) ? $_REQUEST['key'] : null;
		$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : null;
		if(!$key || !$value) exit('参数不完整');
		$data = array($key => $value);
		AdminUser::editUser($_SESSION['user'], $_SESSION['organize_id'], $data);
		break;
	default:
		$info = AdminUser::getInfoByName($_SESSION['user']);
		Templates::Assign('index_hover', "hover");
		Templates::Assign('info', $info);
		Templates::Display('index.tpl');	
}





