<?php
class AdminUser extends ABase
{
	static public $_class = __CLASS__;
	static public $_table = '#_admin_user';
	
	
	static function login($username, $password, $organize_code)
	{
		$organize_id = Organize::getId($organize_code);
		$info = self::getInfoByName($username);
		$passwd = isset($info['password']) ? $info['password'] : null;
		$salt = isset($info['salt']) ? $info['salt'] : null;
		$organizeid = isset($info['organize_id']) ? $info['organize_id'] : 0;
		$password = md5(md5($password).$salt);
		if($passwd != $password) return false;
		if($organizeid != $organize_id) return false;
		return true;
	}
	
	static function changePassword($username, $password, $organize_id)
	{
		$condition = array(
			"username"	 	=> $username,
			"organize_id"	=> $organize_id,
		);
		$info = self::getInfoByName($username);
		$salt = isset($info['salt']) ? $info['salt'] : null;
		$password = md5(md5($password).$salt);
		$data = array(
			"password" 	=> $password,
		);
		return self::update($condition, $data);
	}
	
	static function addUser($username, $organize_id, $realname=null, $nickname=null, $password=null)
	{
		if(!$username || !$organize_id) return false;
		$condition = array(
			"username"	 	=> $username,
			"organize_id"	=> $organize_id,
		);
		if(!self::check(array("condition"=>$condition))){
			$salt = Func::getRandomCode(10);
			$password = md5(md5($password).$salt);
			$data = array(
				"username"			=> $username,
				"realname"			=> $realname,
				"nickname"			=> $nickname,
				"password"			=> $password,
				"salt"				=> $salt,
				"organize_id"		=> $organize_id,
				"role"				=> 1,
				"created_at"		=> Func::getTime(),					
			);
			return self::insert($data);
		}
		return false;
	}
	
	static function editUser($username, $organize_id, array $data)
	{
		if(!$username || !$organize_id) return false;
		$condition = array(
				"username"	 	=> $username,
				"organize_id"	=> $organize_id,
		);
		if(self::check(array("condition"=>$condition))){
			return self::update($condition, $data);
		}
		return false;
	}
	
	static function getInfoByName($name)
	{
		$info = self::getOne(array("username" => $name));
		return $info;
	}
	
	static function setOnline($username)
	{
		$condition = array("username" => $username);
		$data = array("is_online_bytime" => time());
		return self::update($condition, $data);
	}
	
	static function upLoginData($username)
	{
		$condition = array("username" => $username);
		$data = array(
			"is_online_bytime" 	=> time(),
			"last_login_ip"		=> Func::getIP(),
			"last_login_time"	=> Func::getTime(),
		);
		return self::update($condition, $data);
	}
	
	static function getNickName($username, $organize_id)
	{
		if(!$username || !$organize_id) return null;
		$info = self::getOne(array("username" => $username, "organize_id" => $organize_id), "nickname");
		return isset($info['nickname']) ? $info['nickname'] : null;
	}
	
	
}


