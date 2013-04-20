<?php

// Start the session.
session_start();

// Set the error reporting level.
error_reporting(E_ALL | E_STRICT);

// Define the application include path.
define('APPLICATION_PATH', realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . APPLICATION_PATH);

// Define the application credentials.
define('APPLICATION_USER', 'eis');
define('APPLICATION_PASSWORD', 'eis');

// Define the database credentials.
define('DB_DSN', 'mysql:dbname=eis_production;host=localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Initialize the database connection.
try {
	$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
	echo 'Nije moguće uspostaviti vezu prema bazi podataka!';
	exit;
}

// Load the environment variables.
require 'library/environment_variables.php';

// Load the Messages module.
require 'library/messages.php';

// Load the global functions.
require 'library/functions.php';