<?php 
	include './header.php';
?>
	<section>
		<?php 
			include './resource.php';
			// og hent ut tags, vi trenger denne til å sammenlikne innskrevet tekst
		?>
			<h3>Legg inn en ny ressurs</h3>
			<form class="newresource" action="item.php" method="post" onsubmit="checkFields()">
				<h4>Tittel</h4>
				<p>Navn på nettsted, eller en beskrivende tittel på ressursen.</p>
				<input class="textbox" type="text" name="name" />
				
				<h4>URL</h4>
				<p>Lenke til ressursen, fortrinnsvis direkte til det du vil dele.</p>
				<input class="textbox" type="text" name="url" /><br />
				<p><input type="checkbox" name="nourl" />Ingen URL, dette er en lokal ressurs.</p>
				
				<h4>Tags</h4>
				<p>Skriv inn tags separert av komma.</p>
				<input class="textbox" type="text" name="tags" onkeyup="checkTags()" />
				
				<h4>Beskrivelse eller innhold</h4>
				<p>Beskriv så godt som mulig hva ressursen består av og hva den er godt for.</p>
				<textarea name="desc" rows="20"></textarea>
				<input type="submit" value="Ferdig!" />
			</form>
	</section>
	<aside>
		<p>Ressursene du deler kan være alt fra nettsider med programmerings- eller designressurser, til interessant kildekode, kodebiblioteker, eller digitale lærebøker.</p>
		<p>En annen populær bruk av Kande er å skrive inn kodeeksempler direkte, som andre kan ha nytte av. Eller du kan stille et spørsmål, og få svar fra andre brukere.</p>
	</aside>
<?php 
	include './footer.php';
?>