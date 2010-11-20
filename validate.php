<?php
	include './db.php';
	session_start();
	if (connectToDB())
		if (verifyUser($_SESSION['name'], $_SESSION['pass'], false))
			echo 'ok';
?>