<meta charset="utf-8">
<?php
	require './db.php';
	if (isset($_POST['username']) && !empty($_POST['username']))
		$name = $_POST['username'];
	else
		die ("Du må fylle ut et brukernavn. Gå tilbake og prøv igjen.");	
	
	if (isset($_POST['password']) && !empty($_POST['password']))
		$pass = $_POST['password'];
	else
		die ("Du må fylle ut et passord. Gå tilbake og prøv igjen.");
	
	if (isset($name) && isset($pass)) 
		if (connectToDB()) {
			$response = verifyUser($name, $pass, false);
			if (!$response)
				die ("Feil ved pålogging av bruker.");
			else {
				session_id($response['sessionKey']);
				session_start();
				$_SESSION['name'] = $name;
				$_SESSION['pass'] = $pass;
				if ($_GET['intent'] == 'edit.php')
					header('Location:edit.php');
				else 
					header('Location:'.$_SERVER['HTTP_REFERER']);
			}
		}
	

?>