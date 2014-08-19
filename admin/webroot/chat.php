<?php
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
$guest = isset($_REQUEST['u']) ? $_REQUEST['u'] : null;
$from_session = isset($_REQUEST['s']) ? $_REQUEST['s'] : null;

switch ($type){
	case "send":
		$message = isset($_POST['msg']) ? $_POST['msg'] : null;
		UserChat::saveMsg($_SESSION['organize_id'], $from_session, $message, $_SESSION['user'], 'admin', $guest);
		break;
	case "get":
		AdminUser::setOnline($_SESSION['user']);
		$data = array();
		$guestlist = UserChat::getCustomerList($_SESSION['organize_id']);
		$data['guestlist'] = $guestlist;
		$message = UserChat::getUnreadChatInfo($_SESSION['user'], $from_session, $_SESSION['organize_id'], $guest);
		$data['message'] = $message;
		echo json_encode($data);
		break;
	case "history":
		$history = UserChat::getChatHistory($from_session, $_SESSION['organize_id'], $_SESSION['user'], $guest, 1, $page_size=100);
		$data = array(
			"history" 	=>$history,
		);
		echo json_encode($data);
		break;
	default:
		Templates::Assign('guest', $guest);
		Templates::Assign('from_session', $from_session);
		Templates::Assign('nickname', $_SESSION['nickname']);
		Templates::Assign('organize', $_SESSION['organize']);
		Templates::Display('chat.tpl');
		break;
}
