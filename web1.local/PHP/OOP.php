<?php
header('Content-type: text/plain');
?>
OPP 1

<?php
$obj = (object) array('name' => 'John', 'age' => 34);

echo getType($obj)."\n";
echo("Name: ".$obj->name."\n");
echo("Age: ".$obj->age."\n");
?>