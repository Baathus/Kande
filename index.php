<?php 
	include './header.php';
?>
	<section>
		<?php 
			include './resource.php';
			include './db.php';
			
			// se etter getdata for sortering
			if (isset($_GET['sort']) && !empty($_GET['sort']))
				$sort = $_GET['sort'];
			else
				$sort = 'hot';
			
			// se etter start for listing (starter ellers fra 0 og viser 20 ressurser)
			if (isset($_GET['from']) && !empty($_GET['from']))
				$from = $_GET['from'];
			else
				$from = 0;
			
			// SORTERINGSALGORITME (HOT) - kan justeres.
			function hotSort($a, $b) {
				$aHeat = ($a->score / (time() - $a->date)) * 1e7;
				$bHeat = ($b->score / (time() - $b->date)) * 1e7;
				if ($aHeat > $bHeat)
					return -1;
				if ($aHeat < $bHeat)
					return 1;
				return 0;
				}
			
			// sorter etter dato og score
			if ($sort == 'hot')
				if (connectToDB()) {
					// starter fra ?start= og gir de 20 neste
					$resources = getResources($from, 20, 'rating', false, null);
					usort($resources, 'hotSort');  // refererer til sorteringsalgoritme
				}
			
			// sorter etter dato
			if ($sort == 'new')
				if (connectToDB())
					$resources = getResources($from, 20, 'timecreated', false, null);
			
			// sorter etter score
			if ($sort == 'score')
				if (connectToDB())
					$resources = getResources($from, 20, 'rating', false, null);
			
			// vis ressurser
			foreach ($resources as $res)
				$res->display();
			
			if ($from >= 20)
				echo '<a class="left" href="index.php?start='.($from - 20).'">forrige 20</a>';
			
			if (($resources.length - $from) > 20)
				echo '<a class="left" href="index.php?start='.($from + 20).'">neste 20</a>';				
		?>
	</section>
	<aside>
		<div id="contribute"><a href="edit.php">Legg til en ressurs</a></div>
		<p><strong>Kande</strong> hjelper deg å finne de beste tekniske ressursene innen programmering, nettutvikling og beslektede fag.</p>
		<p><strong>Del</strong> dine beste <strong>kilder</strong>, eller egen <strong>kode</strong> som andre kan bruke. Still <strong>spørsmål</strong> og få <strong>svar</strong>. Kande-samfunnet stemmer fram de beste bidragene og diskuterer muligheter.</p>
	</aside>
<?php 
	include './footer.php';
?>