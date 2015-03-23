<?php
header('Content-type: application/json');
$obj = (Object) array('id' => 1, 'name' => 'Christian');
echo json_encode($obj);
?>