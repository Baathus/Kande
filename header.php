<!DOCTYPE html>
<html lang="no">
<head>
	<meta charset="utf-8">
	<title>kande: snarveier til kunnskap</title>
	<!--[if lt IE9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="style.css">
	<script src="script.js"></script>
</head>
<body>
	<div id="container">
	<header>
		<h1><a href=".">kande</a><sup>t</sup></h1>
		<h2>snarveier til kunnskap</h2>
		<nav>
			<ul>
				<li><a href="index.php?sort=hot">Heiteste</a></li>
				<li><a href="index.php?sort=new">Nyeste</a></li>
				<li><a href="index.php?sort=score">Beste</a></li>
				<li><a href="search.php">Søk</a></li>
			</ul>
		</nav>
	</header>
	<div id="register">
		<h3>Du må være registrert eller logget inn</h3>
		<p>Registrering på Kande er kjapt og enkelt. Du trenger kun et brukernavn, passord og å svare på en <a href="http://www.google.com/recaptcha/learnmore">CAPTCHA</a>. Ingen epostadresse er nødvendig.</p>
		<form action="register.php" method="post" onsubmit="">
			<h4>Registrer deg</h4>
			<p>Brukernavn <input class="textbox" type="text" id="newusername" tabindex="0" /></p>
			<p>Passord <input class="textbox" type="text" id="newpassword" tabindex="1" /></p>
			<?php
				// reCaptcha-data, ikke uventa
				require_once('recaptchalib.php');
				$publickey = "";
				echo recaptcha_get_html($publickey);
			?>
			<input id="reg" type="submit" value="Registrer deg" onclick="loggedIn = true;checkLogin()" />
		</form>
		<form id="login" action="login.php" method="post" onsubmit="">
			<h4>...eller logg inn</h4>
			<p>Brukernavn <input class="textbox" type="text" id="username" tabindex="3" /></p>
			<p>Passord <input class="textbox" type="text" id="password" tabindex="4" /></p>
			<input type="submit" value="Logg inn" onclick="loggedIn = true;checkLogin()" />
		</form>
		<a id="exit" onclick="register.style.display='none';grayOut(false);">Lukk vinduet</a>
	</div>