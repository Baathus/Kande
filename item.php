<?php 
	include './header.php';
?>
	<section>
		<?php 
			include './resource.php';
			include './db.php';
			
			// har vi postdata fra edit-skjermen?
			if (isset($_POST['name']) && !empty($_POST['name']) && 
				(!empty($_POST['url']) || !empty($_POST['nourl'])) && 
				isset($_POST['desc']) && !empty($_POST['desc']) &&
				isset($_POST['tags']) && !empty($_POST['tags'])) {
				// skriv tags, separert av komma, mellomrom til array
				$tags = explode(', ', $_POST['tags']);
				// opprett objekt
				$res = new ResourceClass(0, $_POST['name'], $_POST['url'], $_POST['desc'], $tags);
				if (connectToDB()) {
					// skriv ressurs til database, få id i retur
					$id = addResource($res);
					// hvis nourl er satt, sett url direkte til ressursvisning og skriv modifisert objekt til database
					if ($_POST['nourl'] == 'on') {
						$res = getResourceByID($id);
						$res->url = 'item.php?id='.$id;
						modifyResourceByID($id, $res);
					}
				}

			}
			
			// hvis vi har getdata med direkte identifikasjon av ressurs 
			if (isset($_GET['id']) && !empty($_GET['id']))
				$id = $_GET['id'];
			
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