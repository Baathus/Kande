<?php
	if (isset($_GET['id']) && !empty($_GET['id']))
		$id = $_GET['id'];
	include './resource.php';
	include './db.php';
	if (connectToDB()) {
		$res = getResourceByID($id);
		$score = $res->score + 1;
		modifyResourceScoreByID($id, $score);
		echo $score;
	}
	//header('Location:'.$_SERVER['HTTP_REFERER']);
?>