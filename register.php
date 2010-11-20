<meta charset="utf-8">
<?php
	require './db.php';
	
	require_once('recaptchalib.php');
	$privatekey = "";
	$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
		die ("reCAPTCHAen ble ikke besvart riktig. Gå tilbake og prøv igjen. ");
	} else {
		if (isset($_POST['newusername']) && !empty($_POST['newusername']))
			$name = $_POST['newusername'];
		else
			die ("Du må fylle ut et brukernavn. Gå tilbake og prøv igjen.");	
		
		if (isset($_POST['newpassword']) && !empty($_POST['newpassword']))
			$pass = $_POST['newpassword'];
		else
			die ("Du må fylle ut et passord. Gå tilbake og prøv igjen.");
		
		if (isset($name) && isset($pass)) 
			if (connectToDB()) {
				$ok = addUser($name, $pass, '', false);
				if (!$ok)
					die ("Feil ved registrering av bruker.");
				else {
					$response = verifyUser($name, $pass, false);
					session_id($response['sessionKey']);
					session_start();
					$_SESSION['name'] = $name;
					$_SESSION['pass'] = $pass;
					header('Location:'.$_SERVER['HTTP_REFERER']);
					echo 'loggedIn = true';
				}
			}
	}
?>