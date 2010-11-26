<?php
	include_once './resource.php';
	include_once './db.php';
	if (connectToDB()) {
		$now = date('D, d M Y H:i:s T');
		$rss = '<?xml version="1.0" encoding="utf-8"?>'
		.'<rss version="2.0">'
		.'<channel>'
		.'<title>kande - snarveier til kunnskap</title>'
		.'<language>nb-no</language>'
		.'<webMaster>post.kande@gmail.com</webMaster>'
		.'<pubDate>'.$now.'</pubDate>'
		.'<lastBuildDate>'.$now.'</lastBuildDate>';
			
		$resources = getResources(0, 100, 'timecreated', false, array());
		foreach ($resources as $res) {
			$taglinks = '';
			foreach ($res->tags as $n => $tag) {
				$taglinks = $taglinks.$tag;
				if ($n < count($res->tags)-1)
					$taglinks = $taglinks.', ';
			}		
			$rss .= '<item>'
			.'<title>'.$res->name.'</title>'
			.'<link>'.$res->url.'</link>'
			.'<guid>http://kande.dyndns.org/item?id='.$res->id.'</guid>'
			.'<description>'.$res->textReplace($res->description)
			.'<p>Tags: '.$taglinks.'</p></description>'
			.'<pubDate>'.gmdate('D, d M Y H:i:s O', $res->date).'</pubDate>'
			.'</item>';
		}
		$rss .= '</channel>'
		.'</rss>';

		if(!$file = @fopen("rss.xml", "w")) {
			echo "RSS Error.";
		}

		fwrite($file, $rss);
		fclose($file);
	}
?>

