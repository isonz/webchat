<?php
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

if(!$type){
	$error = isset($_REQUEST['error']) ? $_REQUEST['error'] : -1;
	$msg = '';
	switch ($error){
		case 0:
			$msg = "密码修改成功";
			break;
		case 1:
			$msg = "请填写原始密码";
			break;
		case 2:
			$msg = "新密码必须大于等于6个字符";
			break;
		case 3:
			$msg = "两次输入的密码不一致";
			break;
		case 4:
			$msg = "原始密码错误";
			break;
		case 5:
			$msg = "修改失败，可能是网络原因，请稍后再试";
			break;
		default:
			$msg = "";
	}
	Templates::Assign('msg', $msg);
	Templates::Assign('error', $error);
	Templates::Assign('edit_password_hover', "hover");
	Templates::Display('editpassword.tpl');
}else{
	$oldpassword = isset($_REQUEST['oldpassword']) ? $_REQUEST['oldpassword'] : null;
	$newpassword = isset($_REQUEST['newpassword']) ? $_REQUEST['newpassword'] : null;
	$reastpassword = isset($_REQUEST['reastpassword']) ? $_REQUEST['reastpassword'] : null;
	
	if(!$oldpassword){
		header("Location: ?error=1");
		exit;
	}
	if(strlen($newpassword) < 6){
		header("Location: ?error=2");
		exit;
	}
	if($newpassword != $reastpassword){
		header("Location: ?error=3");
		exit;
	}
	
	if(!AdminUser::login($_SESSION['user'], $oldpassword, $_SESSION['organize'])){
		header("Location: ?error=4");
		exit;
	}
	
	if(!AdminUser::changePassword($_SESSION['user'], $newpassword, $_SESSION['organize_id'])){
		header("Location: ?error=5");
		exit;
	}else{
		header("Location: ?error=0");
		exit;
	}
}




