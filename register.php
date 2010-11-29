<?php
	require_once './db.php';
	require_once 'recaptchalib.php';
	$privatekey = "";
	$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
		echo "$('message').innerHTML = 'CAPTCHAen ble ikke besvart riktig. Prøv igjen.'; $('message').style.color = '#d50'"; // evalueres av ajax-funksjonen når den returneres
	} else {
		if (isset($_POST['newusername']) && !empty($_POST['newusername']))
			$name = $_POST['newusername'];
		else
			echo "$('message').innerHTML = 'Du må fylle inn brukernavn.'; $('message').style.color = '#d50'";
		
		if (isset($_POST['newpassword']) && !empty($_POST['newpassword']))
			$pass = $_POST['newpassword'];
		else
			echo "$('message').innerHTML = 'Du må fylle inn passord.'; $('message').style.color = '#d50'";
		
		if (isset($name) && isset($pass)) 
			if (connectToDB()) {
				$ok = addUser($name, $pass, '', false);
				if (!$ok)
					echo "$('message').innerHTML = 'Feil ved registrering av bruker. Kanskje du vil prøve igjen?'; $('message').style.color = '#d50'";
				else {
					$response = verifyUser($name, $pass, false);
					session_id($response['sessionKey']);
					session_start();
					$_SESSION['name'] = $name;
					$_SESSION['pass'] = $pass;
					// hvis brukeren ville gå til redigeringsskjerm, redirect dit, ellers tilbake til samme skjerm
					if ($_GET['intent'] == 'edit.php')
						echo "window.location = 'edit.php'";
					else 
						echo "window.location = '".$_SERVER['HTTP_REFERER']."'";
				}
			}
	}
?>