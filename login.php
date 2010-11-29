<?php
	require_once './db.php';
	if (isset($_POST['username']) && !empty($_POST['username']))
		$name = $_POST['username'];
	else
		echo "$('message').innerHTML = 'Du må fylle inn brukernavn.'; $('message').style.color = '#d50'"; // evalueres av ajax-funksjonen når den returneres
	
	if (isset($_POST['password']) && !empty($_POST['password']))
		$pass = $_POST['password'];
	else
		echo "$('message').innerHTML = 'Du må fylle inn passord.'; $('message').style.color = '#d50'";
	
	if (isset($name) && isset($pass)) 
		if (connectToDB()) {
			$response = verifyUser($name, $pass, false);
			if (!$response)
				echo "$('message').innerHTML = 'Feil ved pålogging. Har du fylt ut riktig?'; $('message').style.color = '#d50'"; 
			else {
				session_id($response['sessionKey']);
				session_start();
				$_SESSION['name'] = $name;
				$_SESSION['pass'] = $pass;
				// hvis brukeren ville gå til redigeringsskjerm, redirect dit, ellers tilbake
				if ($_GET['intent'] == 'edit.php')
					echo "window.location = 'edit.php'";
				else
					echo "window.location = '".$_SERVER['HTTP_REFERER']."'";
			}
		}
?>