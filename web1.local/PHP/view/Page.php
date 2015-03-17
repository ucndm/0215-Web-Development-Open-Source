<?php
class Page{
	var $content;
	function __construct(){
		
	}
	
	function Render(){
		echo($this->content);
	}

	function __destruct(){
		//fire headers
		//echo content
		echo($this->content);
	}
}
?>