<?php
header('Content-type: text/plain');
?>
OPP 1

<?php
class User{
	private $name;
	public $cpr;
	
	//var $name;
	//var $age;
	
	function __construct($name, $age){
		$this->name = $name;
		$this->age = $age;
	}
	
	function GetName(){
		return $this->name;
	}
}

$u1 = new User('Ib', 34);

var_dump($u1);
echo("Name: ".$u1->GetName()."\n");
echo("Age: ".$u1->age."\n\n");

$u1->cpr = '123456-1234';
var_dump($u1);
?>




