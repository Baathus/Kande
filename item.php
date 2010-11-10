<?php 
	include './header.php';
?>
	<section>
		<?php 
			include './resource.php';
			include './db.php';

			// hvis vi har getdata med direkte identifikasjon av ressurs 
			if (isset($_GET['id']) && !empty($_GET['id']))
				$id = $_GET['id'];
			
			// har vi postdata fra edit-skjermen?
			if (isset($_POST['name']) && !empty($_POST['name']) && 
				isset($_POST['desc']) && !empty($_POST['desc']) &&
				isset($_POST['tags']) && !empty($_POST['tags'])) {
				// skriv tags, separert av komma, mellomrom til array
				$tags = explode(',', $_POST['tags']);
				foreach ($tags as $n => $tag)
					$tags[$n] = trim($tag);
					// fjern mellomrom før og etter

				if (connectToDB())
					// hvis vi har getdata OG har postdata kommer vi fra redigering av eksisterende ressurs
					if (isset($id)) {
						$res = getResourceByID($id);
						$res->name = $_POST['name'];
						$res->url = $_POST['url'];
						$res->description = $_POST['desc'];
						$res->tags = $tags;
						modifyResourceByID($id, $res);
					} else {
						// opprett objekt					
						$res = new ResourceClass(0, $_POST['name'], $_POST['url'], $_POST['desc'], $tags);					
						// skriv ressurs til database, få id i retur
						$id = addResource($res);
						// hvis ingen url er satt, sett url direkte til ressursvisning og skriv modifisert objekt til database
						if (empty($_POST['url'])) {
							$res = getResourceByID($id);
							$res->url = 'item.php?id='.$id;
							modifyResourceByID($id, $res);
						}
					}
			}
			
			// hvis vi har en id, vis ressurs
			if (isset($id))
				if (connectToDB()) {
					$res = getResourceByID($id);
					$res->displayFull();
				}
		?>
	</section>
	<aside>
		<p>Hvis du har tips eller tilføyelser, legg inn en kommentar under.</p>
	</aside>
<?php 
	include './footer.php';
?>