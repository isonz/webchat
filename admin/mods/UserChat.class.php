<?php
class UserChat extends ABase
{
	static public $_class = __CLASS__;
	static public $_table = '#_user_chat';
	
	static function saveMsg($organize, $to_session, $message, $from_user=null, $message_from_url=null, $to_user=null, $from_session=null)
	{
		if(!$organize || !$to_session || !$message) return false;
		$data = array(
			"from_session" 		=> $from_session,
			"from_user"			=> $from_user,
			"message"			=> $message,
			"message_from_url"	=> 'admin',
			"created_at"		=> Func::getTime(),
			"to_session"		=> $to_session,
			"to_user"			=> $to_user,
			"ip"				=> Func::getIP(),
			"organize_id"		=> $organize,
		);
		return self::insert($data);
	}
	
	static function getChatHistory($from_session, $organize_id, $to_user, $from_user=null, $page=1, $page_size=50)
	{
		$from_session_col = "from_session";
		if($from_user){
			$from_session = $from_user;
			$from_session_col = "from_user";
		}
		if(!$from_session) return array();
		$info = self::paging($page, $page_size, "($from_session_col='$from_session' OR to_session='$from_session' OR to_user='$from_session') AND organize_id='$organize_id'", 'id ASC', "from_user, message, message_from_url, created_at, organize_id");
		$info['data'] = self::getMsgNickname($info['data']);
		self::updateChatToReaded($from_session, $organize_id, $from_user, $to_user);
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
	
	static function getUnreadChatInfo($to_user, $from_session, $organize_id, $from_user=null)
	{
		$from_session_col = "from_session";
		if($from_user){
			$from_session = $from_user;
			$from_session_col = "from_user";
		}
		if(!$from_session || !$to_user) return array();
		$info = self::getList("$from_session_col='$from_session' AND to_user='$to_user' AND status=0 AND organize_id='$organize_id'", "from_user, message, message_from_url,organize_id, created_at");
		$info = self::getMsgNickname($info);
		self::updateChatToReaded($from_session, $organize_id, $from_user, $to_user);
		return $info;
	}
	
	static function updateChatToReaded($from_session, $organize_id, $from_user=null, $to_user=null)
	{
		$from_session_col = "from_session";
		if($from_user){
			$from_session = $from_user;
			$from_session_col = "from_user";
		}
		if(!$from_session) return false;
		$condition = array(
			$from_session_col	=> $from_session,
			"organize_id"		=> $organize_id,
			'message_from_url'	=> array("!="=>'admin'),
			"status"			=> 0,
		);
		$data = array(
			'to_user' 			=> $to_user,
			"status"			=> time(),
		);
		//DB::Debug();
		return self::update($condition, $data);
	}
	
	static function getCustomerList($organize_id)
	{
		if(!$organize_id) return array();
		$expired_time = time() - (24*3600);
		//DB::Debug();
		$info = self::getList("message_from_url !='admin' AND organize_id='$organize_id' AND (status>$expired_time OR status=0) GROUP BY from_user,from_session", "from_session, from_user", "id ASC");
		$i = 1;
		$tmp = array();
		$online_user = FrontUser::getOnlineUser($organize_id);
		foreach ($info as $k => $v){
			foreach ($online_user as $ok => $ov){
				if($ov['sessionid']==$v['from_session'] && $ov['from_user']==$v['from_user']) unset($online_user[$ok]);
			}
		}
		$change = array();
		foreach ($online_user as $ok => $ov){
			$change[] = array("from_session"=>$ov['sessionid'], "from_user"=>$ov['from_user'], "from_user_nick"=>$ov['from_user']);
		}
		$info = array_merge($info, $change);
		foreach ($info as $k => $v){
			foreach ($online_user as $ok => $ov){
				if($ov['sessionid']==$v['from_session'] && $ov['from_user']==$v['from_user']) unset($online_user[$ok]);
			}
			if(!$v['from_user']) {
				$info[$k]['from_user_nick'] = "游客 $i";
				$i++;
			}else{
				$info[$k]['from_user_nick'] = $v['from_user'];
			}
			$tmp[$info[$k]['from_user_nick']] = array($v['from_session'], $v['from_user']);
		}
		$data  = array();
		foreach ($tmp as $k => $v){
			$data[]=array($k,$v[0],$v[1]);
		}
		return $data;
	}
	
}


