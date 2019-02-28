<?php

global $DB_PREFIX;

$selection = "remote";
if ($selection=='remote') {
	define('DATABASE', 'userxxxx_puc_database');
} else {
	define('DATABASE', 'puc_database');
}

function autenticate() {
	global $selection;
	@mysql_close();
	$error = 'Could not connect!!!<br>';
	if ($selection == 'remote') {
		@mysql_connect('localhost', '*********','*******') or die('Server (remote): '.$error);	
	} else {
		@mysql_connect('localhost', 'root','') or die('Server (local): '.$error);
	}
}

function connect_2($DB) {
	autenticate();
	if (!@mysql_select_db($DB))	die('Could not connect to the database '.$DB);
}
function connect() {
	autenticate();
	if (!@mysql_select_db(DATABASE))	die('Could not connect to the database '.$DB);
}
?>
