<?php 
	include './header.php';
?>
	<section>
		<?php 
			include './resource.php';
			include './db.php';
			// og hent ut tags, vi trenger denne til å sammenlikne innskrevet tekst
			if (connectToDB())
				$tags = getAllTags();
			
			// hvis vi har getdata med direkte identifikasjon av ressurs 
			if (isset($_GET['id']) && !empty($_GET['id']))
				if (connectToDB())
					$res = getResourceByID($_GET['id']);
		?>
			<h3>Legg inn en ny ressurs</h3>
			<form class="newresource" action="item.php<?php if (isset($res->id)) echo '?id='.$res->id; ?>" method="post">
				<h4>Tittel</h4>
				Navn på nettsted, eller en beskrivende tittel på ressursen.
				<input class="textbox" type="text" name="name" value="<?php if (isset($res->name)) echo $res->name; ?>" />
				
				<h4>URL (valgfritt)</h4>
				Hvis dette er en ekstern ressurs, legg inn en lenke, fortrinnsvis direkte til det du vil dele.
				<input class="textbox" type="text" name="url" value="<?php if (isset($res->url)) echo $res->url; ?>" /><br />
				
				<h4>Tags</h4>
				Skriv inn tags separert av komma eller legg til fra lista under. Bruk gjerne eksisterende tags!
				<input class="textbox" type="text" id="tags" name="tags" value="<?php if (isset($res->tags)) echo implode(', ',$res->tags); ?>" onkeyup="checkTags()" />
				<?php
					if (isset($tags))
						foreach ($tags as $n => $tag) {
							echo '<a href="javascript:addTag(\''.$tag.'\')">'.$tag.'</a>';
							if ($n < count($tags)-1)
								echo ', ';
						}
				?>
				
				<h4>Beskrivelse eller innhold</h4>
				Beskriv så godt som mulig hva ressursen består av og hva den er godt for.
				<textarea name="desc" rows="20"><?php if (isset($res->description)) echo $res->description; ?></textarea>
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