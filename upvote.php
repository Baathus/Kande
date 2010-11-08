<?php
	header('Location:'.$_SERVER['HTTP_REFERER']);
	if (isset($_GET['id']) && !empty($_GET['id']))
		$id = $_GET['id'];
	include './resource.php';
	include './db.php';
	connectToDB();
	$res = getResourceByID($id);
	$score = $res->score + 1;
	modifyResourceScoreByID($id, $score);
	// Alternativt, gjør dette med AJAX
?>