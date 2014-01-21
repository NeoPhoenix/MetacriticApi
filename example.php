<?php
	
	require_once('MetacriticApi/MetacriticApi.class.php');
	$api = new MetacriticApi("tv",array("How I Met Your Mother",10));
	print_r(get_object_vars($api));
	
?>