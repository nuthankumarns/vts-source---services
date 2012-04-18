<?php
	include('gmt.class.php');
	$gmt = new gmt();

	echo '<h3>Your server gmt is : '.date('P').'('.date('e').')</h3>';
	echo '<h3>Your server time is : '.date('Y-m-d H:i:s').'</h3>';

	$date = '2009-06-20 05:00:00';

	//EX 1:
	echo '<p>GMT according to your server : '.$gmt->getByGMT().'</p>';

	//EX 2:
	$gmt->setZoneId(3);
	$gmt->setDateToConvert($date);
	echo '<p>GMT Minus 10 hour as on '.$date.' : '.$gmt->getByGMT().'</p>';

	//Reset zone and date
	$gmt->resetZoneId();
	$gmt->resetDateToConvert();

	//EX 1:
	echo '<p>GMT according to your server : '.$gmt->getByGMT().'</p>';

	//EX 3:
	$gmt->setDateToConvert($date);
	echo '<p>GMT as on '.$date.' according to your server : '.$gmt->getByGMT().'</p>';
?>