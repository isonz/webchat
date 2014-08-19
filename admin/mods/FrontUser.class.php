<?php
class FrontUser extends ABase
{
	static public $_class = __CLASS__;
	static public $_table = '#_front_user';
	
	static public $_check_online_time = 30; 	//second
	
	static function getOnlineUser($organize_id)
	{
		$data = self::getList("organize_id='$organize_id' AND is_online_bytime >= ".(time() - self::$_check_online_time), 'sessionid, from_user, staff', 'organize_id DESC');
		return $data;
	}
	
	
}


