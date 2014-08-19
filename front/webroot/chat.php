<?php
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
$organize = isset($_REQUEST['o']) ? (int)$_REQUEST['o'] : null;
$from_session = isset($_REQUEST['s']) ? $_REQUEST['s'] : null;
$from_user = isset($_REQUEST['u']) ? $_REQUEST['u'] : null;


switch ($type){
	case "send":
		$message = isset($_POST['msg']) ? addslashes($_POST['msg']) : null;
		$from_url = isset($_POST['r']) ? $_POST['r'] : null;
		$to_user = isset($_REQUEST['tu']) ? $_REQUEST['tu'] : null;
		UserChat::saveMsg($organize, $from_session, $message, $from_user, $from_url, $to_user);
		break;
	case "get":
		FrontUser::setOnline($from_session, $organize);
		$message = UserChat::getUnreadChatInfo($from_session, $organize, $from_user);
		$to_user = AdminUser::selectAStaffToCustomer($from_session, $organize);
		FrontUser::saveUser($from_session, $to_user["username"], $organize);
		$data = array(
			"message" 	=> $message,
			"to_user"	=> $to_user,
		);
		echo json_encode($data);
		break;
	case "history":
		$history = UserChat::getChatInfo($from_session, $organize, $from_user, 1, 50);
		$history = json_encode($history);
		FrontUser::setOnline($from_session, $organize);
		echo $history;
		break;
	default:
		break;
}

