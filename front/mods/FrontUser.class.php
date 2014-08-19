<?php
class FrontUser extends ABase
{
	static public $_class = __CLASS__;
	static public $_table = '#_front_user';
	
	static public $_check_online_time = 30; 	//second
	
	static function saveUser($sessionid, $staff=null, $organize_id=0, $from_user=null)
	{
		if(!$sessionid) return false;
		$condition = array("sessionid"=> $sessionid);
		if(!self::check(array("condition"=>$condition))){
			$data = array(
				"sessionid"			=> $sessionid,
				"from_user"			=> $from_user,
				"created_at"		=> Func::getTime(),
				"login_ip"			=> Func::getIP(),
				"is_online_bytime" 	=> time(),
				"staff"				=> $staff,
				"organize_id"		=> $organize_id,
			);
			return self::insert($data);
		}else{
			$data = array(
				"login_ip"			=> Func::getIP(),
				"is_online_bytime" 	=> time(),
				"staff"				=> $staff,
				"organize_id"		=> $organize_id,
			);
			return self::update($condition, $data);
		}
	}
	
	static function setOnline($sessionid, $organize_id)
	{
		$condition = array("sessionid" => $sessionid);
		$data = array("is_online_bytime" => time());
		return self::update($condition, $data);
	}
	
	static function getStaff($sessionid, $organize_id)
	{
		$info = self::getOne(array("sessionid" => $sessionid, "organize_id" => $organize_id), "staff");
		return $info;
	}
	
}


