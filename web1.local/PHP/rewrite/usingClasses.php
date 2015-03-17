<?php
$GLOBALS['lib']['classlib'] = '../classLib/';
$GLOBALS['lib']['view'] = '../view/';

/* __autoload */
function __autoload($class_name){
	if(strstr($class_name, 'Page')){
		require_once $GLOBALS['lib']['view'].$class_name.'.php';
	}else{
		require_once $GLOBALS['lib']['classlib'].$class_name.'.php';
	}
}
/* slit path into array */
$pathSplit = explode('/', $_GET['path']);
$page = null;

if(count($pathSplit) > 1 || $_GET['path'] != ''){
	$classDB = ucfirst($pathSplit[0]).'DB';
	$method = 'Get'.ucfirst($pathSplit[0]);
	$view = ucfirst($pathSplit[0]).'Page';
	$objectParams = array_slice($pathSplit, 1);
	//create object
	$object = $classDB::$method($objectParams);
	//create view
	$page = new $view($object);
}else{
	echo("index");
}

?>