<?php
	session_start();
	include './header.php';
	include './resource.php';
	include './db.php';

	// viser mest populære tags på forsiden for filtering
	if (connectToDB()) {
		// hent tags
		$tags = getAllTags();
		$tagnames = array();
		$tagscores = array();
		// tags ligger som 2-dimensjonal array med tags[0] = tagnavn og array[1] = hyppighet
		foreach ($tags as $tag) {
			$tagnames[] = $tag[0];
			$tagscores[] = $tag[1];
		}
		// sorterer tagnames etter synkende tagscores
		array_multisort($tagscores, SORT_DESC, $tagnames);
		// vi trenger bare de første 50
		$tagnames = array_slice($tagnames, 0, 50);
		echo '<div id="fronttags" class="tags">';
		echo '<strong>Populære tags: </strong>';
		// for hver (sorterte) tag, skriv tag
		foreach ($tagnames as $n => $tag) {
			echo '<a class="tag" href="javascript:searchResult(searchDefault(), \'&amp;tags[]='.urlencode($tag).'\')">'.str_replace(' ','&nbsp;',$tag).'</a>';
			if ($n < count($tagnames)-1)
				echo ' ';
		}
		echo '</div>';
	}
?>
	<section>
		<nav>
			<a href="index.php?sort=hot" title="Sorterer etter en kombinasjon av alder og poeng">Heiteste</a> <a href="index.php?sort=new" title="Sorterer etter alder">Nyeste</a> <a href="index.php?sort=score" title="Sorterer etter poeng">Beste</a> <form id="search" action="index.php" method="get"><input class="textbox" type="text" name="q" id="q" value="Søk..." onkeyup="searchResult(this.value, '')" onfocus="this.value = ''" onblur="if (this.value == '') this.value = 'Søk...'" title="Skriv inn søkeord for å finne ressurser eller tags" /></form>
		</nav>
		<div id="results">
		<?php 
			// livesearch inneholder visning av ressurser etter sortering, tags og søkestreng
			include './livesearch.php';
		?>
		</div>
	</section>
	<aside>
		<div id="contribute" title="...eller still et spørsmål!"><script>document.write('<a href="javascript:checkLogin(\'edit.php\')">Legg til en ressurs</a>');</script><noscript><a href="edit.php">Legg til en ressurs</a></noscript></div>
		<?php include './usermeta.php'; ?>
		<p><strong>Kande</strong> hjelper deg å finne de beste nettbaserte ressursene innen programmering, nettutvikling og beslektede fag.</p>
		<p><strong>Del</strong> dine beste <strong>kilder</strong>, eller egen <strong>kode</strong> som andre kan bruke. Still <strong>spørsmål</strong> og få <strong>svar</strong>. Kande-samfunnet stemmer fram de beste bidragene og diskuterer muligheter.</p>
	</aside>
<?php 
	include './footer.php';
?>