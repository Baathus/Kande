<?php
class ResourceClass {
	
	public $id;
	public $name;
	public $url;
	public $description;
	public $tags = array();
	public $score;
	public $date;
	public $owner;
	public $comments = array();
	
	// kun navn, url og beskrivelse er nødvendig
	function __construct($i=0, $n, $u, $d, $t=array(), $s=1, $dt=0, $o=null, $c=array()) {
		$this->id = $i;
		$this->name = (string)$n;
		$this->url = (string)$u;
		$this->description = (string)$d;
		$this->tags = $t;
		$this->score = $s;
		$this->date = $dt;
		$this->owner = $o;
		$this->comments = $c;
	}

	// Works out the time since the entry post, takes a an argument in unix time (seconds) 
	// http://www.dreamincode.net/code/snippet86.htm
	// modifisert fra engelsk
	function time_since($original) {
		// array of time period chunks
		$chunks = array(
			array(60 * 60 * 24 * 365 , 'år'),
			array(60 * 60 * 24 * 30 , 'måned'),
			array(60 * 60 * 24 * 7, 'uke'),
			array(60 * 60 * 24 , 'dag'),
			array(60 * 60 , 'time'),
			array(60 , 'minutt'),
		);
		
		$today = time(); /* Current unix time  */
		$since = $today - $original;
		
		// $j saves performing the count function each time around the loop
		for ($i = 0, $j = count($chunks); $i < $j; $i++) {
			
			$seconds = $chunks[$i][0];
			$name = $chunks[$i][1];
			
			// finding the biggest chunk (if the chunk fits, break)
			if (($count = floor($since / $seconds)) != 0) {
				// DEBUG print "<!-- It's $name -->\n";
				break;
			}
		}
		
		if ($count == 1) 
			$print = '1 '.$name;
		else if ($name == 'år') 
			$print = "$count {$name}";
		else if ($name == 'time') 
			$print = "$count {$name}r";
		else 
			$print = "$count {$name}er";
		
		/*
		if ($i + 1 < $j) {
			// now getting the second item
			$seconds2 = $chunks[$i + 1][0];
			$name2 = $chunks[$i + 1][1];
			
			// add second item if it's greater than 0
			if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
				if ($count2 == 1) 
					$print .= ',<br />1 '.$name2;
				else if ($name2 == 'år') 
					$print .= ",<br />$count2 {$name2}";
				else if ($name2 == 'time') 
					$print .= ",<br />$count2 {$name2}r";
				else 
					$print .= ",<br />$count2 {$name2}er";
			}
		}
		*/
		return $print;
	}
	
	function display() {
		$taglinks = '';
		foreach ($this->tags as $n => $tag) {
			$taglinks = $taglinks.'<a href="search.php?q=&tags[]='.$tag.'">'.$tag.'</a>';
			if ($n < count($this->tags)-1)
				$taglinks = $taglinks.', ';
		}
		
		if (count($this->comments) == 1)
			$commentString = '1 kommentar';
		else
			$commentString = count($this->comments).' kommentarer';

		echo '<div class="resource">'
		.'<div class="vote">'
		.'<h3>'.$this->score.'</h3>'
		.'<p class="points">poeng</p>'
		.'<p class="date">Alder:<br/>'.$this->time_since($this->date).'</p>'
		.'<p><a href="upvote.php?id='.$this->id.'">Stem</a></p>'
		.'</div>'		//vote
		.'<div class="data">'
		.'<h3><a href="'.$this->url.'">'.$this->name.'</a></h3>'
		.'<p>'.substr($this->description, 0, 150).' [...]</p>'
		.'<p>'.$taglinks.'</p>'		
		.'<p><a class="full" href="item.php?id='.$this->id.'">Full informasjon og '.$commentString.'</a></p>'
		.'</div>'		//data
		.'</div>';		//resource
	}
	
	function displayFull() {
		$taglinks = '';
		foreach ($this->tags as $n => $tag) {
			$taglinks = $taglinks.'<a href="search.php?q=&tags[]='.$tag.'">'.$tag.'</a>';
			if ($n < count($this->tags)-1)
				$taglinks = $taglinks.', ';
		}
		
		if (count($this->comments) == 1)
			$commentString = '1 kommentar';
		else
			$commentString = count($this->comments).' kommentarer';

		$commentList = '';
		foreach ($this->comments as $com)
			$commentList = '<div class="comment"><p>'.$com.'</p></div>';
			
		echo '<div class="resource">'
		.'<div class="vote">'
		.'<h3>'.$this->score.'</h3>'
		.'<p class="points">poeng</p>'
		.'<p class="date">Alder:<br/>'.$this->time_since($this->date).'</p>'
		.'<p><a href="upvote.php?id='.$this->id.'">Stem</a></p>'
		.'</div>'		//vote
		.'<div class="data">'
		.'<h3><a href="'.$this->url.'">'.$this->name.'</a></h3>'
		.'<p>'.$this->description.'</p>'
		.'<p>'.$taglinks.'</p>'
		.'<p><a href="edit.php?id='.$this->id.'">Rediger</a></p>'
		.'</div>'		//data
		.'</div>';		//resource
		echo '<div class="comments">'
		.'<h4>'.$commentString.'</h4>'
		.$commentList
		.'</div>';		//comments
	}
	
}
?>