<?php 
	include './header.php';
?>
	<section>
		<?php 
			include './resource.php';
			include './db.php';
		?>
		<h3>Søk eller filtrer etter tags</h3>
		<form id="search" action="search.php" method="get">
			<h4>Søkeord</h4>
			<input class="textbox" type="text" name="q" onkeyup="" />
			<h4>Tags</h4>
			<?php
				if (connectToDB()) {
					$tags = getAllTags();
					$taglinks = '';
					echo '<p>';
					foreach ($tags as $n => $tag) {
						echo '<input type="checkbox" name="tags[]" value="'.$tag.'" />'.$tag;
						// legg gjerne inn en endring for å unngå break mellom checkbox og tagnavn her
						if ($n < count($tags)-1)
							echo ' ';
					}
					echo '</p>';
				}
			?>
			<input type="submit" value="Søk" />
		</form>
		<h4>Resultater:</h4>
		<?php
			if (isset($_GET['from']) && !empty($_GET['from']))
					$from = explode(',',$_GET['from']);
			if (connectToDB()) {
				$resources = getResources($from = 0, 100, 'rating', false, null);
				
				$taglist = array();
				if (isset($_GET['tags']) && !empty($_GET['tags']))
					$taglist = $_GET['tags'];
				
				if (isset($_GET['q']) && !empty($_GET['q']))
					$search = $_GET['q'];
			
				foreach ($resources as $res) {
					if (!empty($search)) {
						if (stristr($res->name, $search) != false) // not false fordi stristr returnerer string eller false 
							$res->display();
						else if (stristr($res->description, $search) != false)
							$res->display();
					}
					foreach ($taglist as $tag) 
						if (in_array($tag, $res->tags))
							$res->display();
				}
			}
		?>
	</section>
	<aside>
		<p>Skriv inn et søkeord og/eller hak av tagsene du vil ha med.</p>
		<p>Resultatene blir kontinuerlig oppdatert med valgene dine.</p>
	</aside>
<?php 
	include './footer.php';
?>