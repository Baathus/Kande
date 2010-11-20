	<div id="register">
		<h3>Du må være registrert eller logget inn for å bidra</h3>
		<p>Registrering på <strong>Kande</strong> er kjapt og enkelt. Du trenger kun et brukernavn og passord, og vise at du er menneske.</p>
		<form action="register.php" method="post">
			<h4>Registrer deg</h4>
			Brukernavn <input class="textbox" type="text" name="newusername" maxlength="32" />
			Passord <input class="textbox" type="password" name="newpassword" maxlength="32" />
			<?php
				require_once('recaptchalib.php');
				$publickey = "";
				echo recaptcha_get_html($publickey);
			?>
			<input id="reg" type="submit" value="Registrer deg" />
		</form>
		<form id="login" action="login.php" method="post">
			<h4>...eller logg inn</h4>
			Brukernavn <input class="textbox" type="text" name="username" maxlength="32" />
			Passord <input class="textbox" type="password" name="password" maxlength="32" />
			<input type="submit" value="Logg inn" tabindex="6" />
		</form>
		<a id="exit" href="javascript:hide()">Lukk vinduet</a>
	</div>
	<footer>
		<div class="col">
			<p>Kande er under kontinuerlig utvikling. Hvis du finner bugs, sikkerhetshull, har tips til forbedringer, eller spørsmål:</p>
			<p><a href="mailto:post.kande@gmail.com">Kontakt webmaster</a></p>
		</div>
			<p><a href="http://www.stud.hio.no/~s169977/wiki/">Les mer om prosjektet</a></p>
			<p><a href="http://github.com/tangram/Kande">Åpen kildekode</a></p>
			<p><a href="http://validator.w3.org/check?uri=referer">Valid HTML5</a></p>
	</footer>
	</div>
</body>
</html>