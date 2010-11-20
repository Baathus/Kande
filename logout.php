<?php
	session_start();
	session_destroy();
	if (stristr($_SERVER['HTTP_REFERER'], 'edit') == false) 
		header('Location:'.$_SERVER['HTTP_REFERER']);
	else
		header('Location:.');
?>