<div id="userdata">
	<?php 
		session_start();
		if (isset($_SESSION['name']))
			echo '<p>Logget inn som <a href="user.php?uid='.$_SESSION['name'].'">'.$_SESSION['name'].'</a>. <a href="logout.php">Logg ut</a>.</p>';
		else
			echo '<p>Du er ikke logget inn. <a href="javascript:checkLogin()">Logg inn</a>.</p>';
	?>
</div>