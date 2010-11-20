<?php
	include './db.php';
	if (connectToDB()) {
		$tags = getAllTags();
		foreach ($tags as $n => $tag) {
			echo $tag[0];
			if ($n < count($tags)-1)
				echo ',';
		}
	}
?>