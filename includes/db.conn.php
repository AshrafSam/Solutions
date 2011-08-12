<?php

	// including database class
	require_once './classes/db.class.php';

	// catching connection exceptions
	try {
		$db = new DB($dbhost, $dbuser, $dbpass, $dbname);
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}

?>