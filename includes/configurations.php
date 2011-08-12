<?php

	// is it on debug mode?
	define('DEBUG', true);
	
	// when it's on debug mode, show all errors, otherwise: show no errors!
	error_reporting((DEBUG ? -1 : 0));

	// Database Configurations						
	$dbinfo = array(
							'host' => 'localhost',
							'user' => 'root',
							'pass' => '',
							'name' => 'dabberni'
						);
	

?>