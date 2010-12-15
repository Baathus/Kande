<?php
	include_once './resource.php';
	include_once './db.php';

	if (connectToDB()) {
		// se etter getdata for tags
		$taglist = array();
		if (isset($_GET['tags']) && !empty($_GET['tags']))
			$taglist = $_GET['tags'];
		else
			$taglist = null;
		
		// se etter getdata for søk
		if (isset($_GET['q']) && !empty($_GET['q']))
			$search = $_GET['q'];
		
		// se etter getdata for sortering, hvis ikke, sorter etter heiteste
		if (isset($_GET['sort']) && !empty($_GET['sort']))
			$sort = $_GET['sort'];
		else
			$sort = 'hot';
		
		// se etter start for listing (starter ellers fra 0 og viser 100 ressurser)
		if (isset($_GET['from']) && !empty($_GET['from']))
			$from = $_GET['from'];
		else
			$from = 0;
			
		// SORTERINGSALGORITME (HOT) - kan justeres.
		function hotSort($a, $b) {
			$aHeat = ($a->score*20 / (time() - $a->date)) * 1e7;
			$bHeat = ($b->score*20 / (time() - $b->date)) * 1e7;
			if ($aHeat > $bHeat)
				return -1;
			if ($aHeat < $bHeat)
				return 1;
			return 0;
			}
		
		// sorter etter dato og score
		if ($sort == 'hot')
			if (connectToDB()) {
				// starter fra ?start= og gir de 100 neste
				$resources = getResources($from, 100, 'rating', false, $taglist);
				usort($resources, 'hotSort');  // refererer til sorteringsalgoritme
			}
		
		// sorter etter dato
		if ($sort == 'new')
			if (connectToDB())
				$resources = getResources($from, 100, 'timecreated', false, $taglist);
		
		// sorter etter score
		if ($sort == 'score')
			if (connectToDB())
				$resources = getResources($from, 100, 'rating', false, $taglist);
			
		foreach ($resources as $res) {
			// hvis vi har en søkestreng
			if (!empty($search)) {
				// hvis search er i tittelen på ressurs, vis
				if (stristr($res->name, $search) != false) // not false fordi stristr returnerer string eller false 
					$res->display(array($search));
				// hvis search er i beskrivelse, vis
				else if (stristr($res->description, $search) != false)
					$res->display(array($search));
				// eller hvis search er i tags, vis (case-insensitive)
				else if (in_array(strtolower($search), array_map('strtolower', $res->tags)))
					$res->display();
				// men vis altså bare hver tag en gang
			} else
				// hvis vi ikke har søkestreng, bare vis ressurser, evt. basert på tags
				$res->display();
		}
	}
?>