<?php
$errmsg = '';

if(isset($_GET['in'])){
	$user = isset($_POST['user']) ? $_POST['user'] : null;
	$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : null;
	$yzm = isset($_POST['yzm']) ? $_POST['yzm'] : null;
	$organize = isset($_POST['organize']) ? $_POST['organize'] : null;
	
	require_once _LIBS."Vcode/Vcode.class.php";
	$vcode = strtolower(Vcode::getCode());
	if($yzm != $vcode){
		$errmsg = "验证码错误";
	}else{
		if(AdminUser::login($user, $passwd, $organize)){
			$_SESSION['user'] = $user;
			
			$info = AdminUser::getInfoByName($user);
			$_SESSION['nickname'] = $info['nickname'];
			$_SESSION['organize'] = $organize;
			$_SESSION['organize_id'] = $info['organize_id'];
			
			AdminUser::upLoginData($user);
			header('Location: /');
		}else{
			$errmsg = "用户名或密码错误";
		}		
	}
	
}

if(isset($_GET['out'])){
	session_destroy();
	session_unset();
	unset($_SESSION);
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
Templates::Assign('user', $user);
Templates::Assign('errmsg', $errmsg);
Templates::Display('sign.tpl');

