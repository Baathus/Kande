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
	
	function display() {
		$taglinks = '';
		foreach ($this->tags as $n => $tag) {
			$taglinks = $taglinks.'<a href="">'.$tag.'</a>';
			if ($n < count($this->tags)-1)
				$taglinks = $taglinks.', ';
		}
		
		if (count($this->comments) == 1)
			$commentString = '1 kommentar';
		else
			$commentString = count($this->comments).' kommentarer';

		echo '<div class="resource">'
		.'<div class="vote">'
		.'<p><a href="upvote.php?id='.$this->id.'">Stem</a></p>'
		.'<h3>'.$this->score.'</h3>'
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
			$taglinks = $taglinks.'<a href="">'.$tag.'</a>';
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