<?php
class User{
	private $id;
	private $name;
	public $age;
	
	function __construct($id, $name, $age){
		$this->id = $id;
		$this->name = $name;
		$this->age = $age;
	}
	
	function GetName(){
		return $this->name;
	}
	
	function GetAge(){
		return $this->age;
	}
	
	function __destruct(){
		echo 'destruct';
	}
}
?>