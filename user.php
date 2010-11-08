<?php
class UserClass {
	
	public $id;
	public $name;
	public $password;
	public $posts = array();
	public $votes = array();
	
	function __construct($i=0, $n, $p, $r=array(), $v=array()) {
		$this->id = $i;
		$this->name = (string)$n;
		$this->password = $p;
		$this->posts = $r;
		$this->votes = $v;
	}
}
?>