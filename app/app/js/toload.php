<?php
	header("Content-type: text/javascript");
	
	require '../php/fetch.php';
	
	$array = start();
	
	echo "var panes = ".json_encode($array);
?>