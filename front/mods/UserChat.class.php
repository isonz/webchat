<?php
class UserChat extends ABase
{
	static public $_class = __CLASS__;
	static public $_table = '#_user_chat';
	
	static function saveMsg($organize, $from_session, $message, $from_user=null, $message_from_url=null, $to_user=null, $to_session=null)
	{
		if(!$organize || !$from_session || !$message) return false;
		$data = array(
			"from_session" 		=> $from_session,
			"from_user"			=> $from_user,
			"message"			=> $message,
			"message_from_url"	=> $message_from_url,
			"created_at"		=> Func::getTime(),
			"to_session"		=> $to_session,
			"to_user"			=> $to_user,
			"ip"				=> Func::getIP(),
			"organize_id"		=> $organize,
		);
		return self::insert($data);
	}
	
	static function getChatInfo($from_session, $organize_id, $from_user=null, $page=1, $page_size=50)
	{
		$from_session_col = "from_session";
		if($from_user){
			$from_session = $from_user;
			$from_session_col = "from_user";
		}
		if(!$from_session) return array();
		$info = self::paging($page, $page_size, "($from_session_col='$from_session' OR to_session='$from_session' OR to_user='$from_session') AND organize_id='$organize_id'", 'id ASC', "from_session, from_user, message, message_from_url, created_at, organize_id");
		$info['data'] = self::getMsgNickname($info["data"]);
		self::updateChatToReaded($from_session, $organize_id, $from_user);
		return $info;
	}
	
	static function getUnreadChatInfo($to_session, $organize_id, $to_user=null)
	{
		$to_session_col = "to_session";
		if($to_user){
			$to_session = $to_user;
			$to_session_col = "to_user";
		}
		$info = self::getList("$to_session_col='$to_session' AND status=0 AND organize_id='$organize_id'", "from_user, message, message_from_url, created_at, organize_id");
		$info = self::getMsgNickname($info);
		self::updateChatToReaded($to_session, $organize_id, $to_user);
		return $info;
	}
	
	static function getMsgNickname(array $info)
	{
		if(!is_array($info) || empty($info)) return false;
		foreach ($info as $k => $v){
			$info[$k]['message'] = stripcslashes($v['message']);
			$username = $v['from_user'];
			$organize_id = $v["organize_id"];
			$message_from_url = $v['message_from_url'];
			if('admin'!=$message_from_url || !$username || !$organize_id) continue;
			$nickname = AdminUser::getNickName($username, $organize_id);
			$info[$k]["nickname"] = $nickname;
		}
		return $info;
	}
	
	static function updateChatToReaded($to_session, $organize_id, $to_user=null)
	{
		$to_session_col = "to_session";
		if($to_user){
			$to_session = $to_user;
			$to_session_col = "to_user";
		}
		
		$condition = array(
			$to_session_col 	=> $to_session,
			"organize_id"		=> $organize_id,
			"status"			=> 0,
		);
		$data = array(
			"status"			=> time(),
		);
		return self::update($condition, $data);
	}
	
	
}


