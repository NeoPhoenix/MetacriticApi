<?php
	
	require_once('MetacriticApi/MetacriticApi.class.php');
	
	$bb = new MetacriticApi("tv",array("Breaking Bad",3));
	echo 'Breaking Bad\'s third season has been rated '.$bb->metascore.'/100.<br/>';
	
	$bf4 = new MetacriticApi("game",array("pc","Battlefield 4"));
	echo 'Only '.number_format(100*$bf4->userscore_d[0]/array_sum($bf4->userscore_d),1).'% of its users liked Battlefield 4 (PC)<br/>';
	
	$ah = new MetacriticApi("movie",array("American Hustle"));
	echo $ah->critic_reviews[0]['author'].' wrote about American Hustle: "'.$ah->critic_reviews[0]['review'].'"<br/>';
	
	$ats = new MetacriticApi("music",array('A Thousand Suns','Linkin Park'));
	echo $ats->userscore_d[1].' of '.array_sum($ats->userscore_d).' users were unsure about Linkin Park\'s "A Thousand Suns"';
	
?>