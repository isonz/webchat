<?php
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

if(!$type){
	$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : -1;
	$msg = '';
	switch ($error){
		case 0:
			$msg = "添加成功";
			break;
		case 1:
			$msg = "请填写完整信息";
			break;
		case 2:
			$msg = "新密码必须大于等于6个字符";
			break;
		case 3:
			$msg = "添加失败，可能存在相同的用户名";
			break;
		default:
			$msg = "";
	}
	Templates::Assign('msg', $msg);
	Templates::Assign('error', $error);
	Templates::Assign('addmember_hover', "hover");
	Templates::Display('addmember.tpl');
}else if('add' == $type){
	$username = isset($_POST['username']) ? $_POST['username'] : null;
	$password = isset($_POST['password']) ? $_POST['password'] : null;
	$realname = isset($_POST['realname']) ? $_POST['realname'] : null;
	$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : null;
	
	if(!$username || !$password || !$realname || !$nickname){
		header("Location: ?error=1");
		exit;
	}
	if(strlen($password) < 6){
		header("Location: ?error=2");
		exit;
	}
	
	if(!AdminUser::addUser($username, $_SESSION['organize_id'], $realname, $nickname, $password)){
		header("Location: ?error=3");
		exit;
	}else{
		header("Location: ?error=0");
		exit;
	}
}




