<?php
	include './resource.php';
	include './db.php';
	if (connectToDB()) {
		
		echo '<rss version="2.0">'
		.'<channel>'
		.'<title>kande - snarveier til kunnskap</title>'
<link>YOURURLLINK</link>
<description>YOURDESCRIPTION</description>
<language>nb-no</language>
<copyright>YOURCOPYRIGHT</copyright>
		$taglinks = '';
		foreach ($this->tags as $n => $tag) {
			$taglinks = $taglinks.$tag;
			if ($n < count($this->tags)-1)
				$taglinks = $taglinks.', ';
		}
		
		echo '<div class="resource">'
		.'<div class="vote">'
		.'<a href="javascript:checkLogin(\'upvote.php?id='.$this->id.'\')"><img alt="Stem opp" title="Stem opp" src="upvote.gif" style="height: 16px" /></a>' // <noscript><a href="upvote.php?id='.$this->id.'"><img alt="Stem opp" title="Stem opp" src="upvote.gif" style="height: 16px" /></a></noscript>
		.' <span class="score" id="scoreID'.$this->id.'">'.$this->score.'</span>'
		.' poeng, '
		.' <span class="userdate">skrevet av <a href="user.php?uid='.urlencode($this->owner).'">'.$this->owner.'</a> for '.$this->time_since($this->date).' siden</span>';
		include_once './db.php';
		session_start();
		if (connectToDB()) {
			$s = verifyUser($_SESSION['name'], $_SESSION['pass'], false);
			if (($s['user'] == $this->owner) || ($s['auth'] == 3))
				echo ' (<a href="edit.php?id='.$this->id.'">rediger</a> | <a href="delete.php?id='.$this->id.'">slett</a>)';
		}
		echo ' (<a href="report.php?id='.$this->id.'">rapporter</a>)'
		.'</div>'		//vote
		.'<div class="data">'
		.'<h3><a href="'.$this->url.'">'.$this->name.'</a></h3>'
		.$this->textReplace($this->description)
		.'<p class="tags"><strong>Tags: </strong>'.$taglinks.'</p>'
		.'</div>'		//data
		.'</div>';		//resource
<lastBuildDate><%=CurrDateT%></lastBuildDate>
<ttl>240</ttl>
<image>
<url>YOURSITEIMAGEFILE</url>
<title>YOURSITENAME</title>
<link>YOURSITEURL</link>
</image>

?>