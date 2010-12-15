<?php
	include './db.php';
	session_start();
	if (connectToDB())
		if (verifyUser($_SESSION['name'], $_SESSION['pass'], false)) {
			mail('post.kande@gmail.com', 
				'[Rapportert ressurs] rid='.$_GET['id'], 
				'<a href="http://kande.dyndns.org/item.php?id='.$_GET['id'].'">Denne ressursen</a> er rapportert av <a href="'.$_SESSION['name'].'">'.$_SESSION['name'].'</a>.', 
				'From: post.kande@gmail.com');
	}
	//header('Location:'.$_SERVER['HTTP_REFERER']);
?>