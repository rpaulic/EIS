<?php

// Redirect to the login form if the user is not logged in.
if (!$logged_in) {
	header('Location: /login');
	exit;
}

// Process logout.
$_SESSION = array();
session_destroy();

// Start a new session.
session_start();
$_SESSION['flash'] = 'Uspješno ste se odjavili.';

// Redirect on completion.
header('Location: /login');
exit;