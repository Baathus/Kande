<?php
	require './db.php';
	session_start();
	if (!empty($_SESSION['name']) && !empty($_SESSION['pass']))
		if (isset($_GET['rid']) && !empty($_GET['rid']) &&
			isset($_POST['comment']) && !empty($_POST['comment']))
			if (connectToDB())
				if (isset($_GET['cid']) && !empty($_GET['cid'])) {
					$s = verifyUser($_SESSION['name'], $_SESSION['pass'], false);
					$c = getCommentByCID($_GET['cid']);
					// hvis bruker er eier eller har auth == 3
					if (($_SESSION['name'] == $c['uid']) || ($s['auth'] == 3))
						modifyCommentByCID($_GET['cid'], $_POST['comment']);
				} else {
					$s = verifyUser($_SESSION['name'], $_SESSION['pass'], false);
					if ($s)
						addComment($_GET['rid'], $_SESSION['name'], $_POST['comment']);
				}
	header('Location:item.php?id='.$_GET['rid']);
?>