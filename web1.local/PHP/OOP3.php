<?php
header('Content-type: text/plain');
?>
OPP 3
<?php
/* __autoload */
function __autoload($class_name){
	require_once 'classLib/'.$class_name.'.php';
}

$user = new User(1, 'Poul', 34);
var_dump($user);
?>