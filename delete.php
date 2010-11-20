<?php
	session_start();
	include './resource.php';
	include './db.php';
	
	header('Location:.'); // default

	// hvis vi har getdata med direkte identifikasjon av ressurs og session-navn og -passord
	if (isset($_GET['id']) && !empty($_GET['id']) && !empty($_SESSION['name']) && !empty($_SESSION['pass']))
		if (connectToDB()) {
			// sjekk at bruker er ok
			$s = verifyUser($_SESSION['name'], $_SESSION['pass'], false);
			// hent ressurs for � sjekke owner
			$r = getResourceByID($_GET['id']);
			// hvis bruker er eier eller har auth == 3, slett
			if (($_SESSION['name'] == $r->owner) || ($s['auth'] == 3)) {
				deleteResourceByID($_GET['id']);
				$coms = getCommentsByRID($_GET['id'], 0, 1000, true);
				foreach ($coms as $c)
					deleteCommentByCID($c['cid']);
			}
		}
	
	// hvis vi har getdata med kommentar
	if (isset($_GET['cid']) && !empty($_GET['cid']) && !empty($_SESSION['name']) && !empty($_SESSION['pass']))
		if (connectToDB()) {
			// sjekk at bruker er ok
			$s = verifyUser($_SESSION['name'], $_SESSION['pass'], false);
			// hent kommentar for � sjekke uid
			$c = getCommentByCID($_GET['cid']);
			// hvis bruker er eier eller har auth == 3, slett
			if (($_SESSION['name'] == $c['uid']) || ($s['auth'] == 3))
				modifyCommentByCID($_GET['cid'], '(kommentaren er slettet)');
				header('Location:'.$_SERVER['HTTP_REFERER']);
		}
?>