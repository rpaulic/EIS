<?php

if ($request_method == 'GET') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'index':
			require 'models/login/index.php';
			loadView($controller, $action, 'Prijava');
			break;
		case 'sign-out':
			require 'models/login/sign_out.php';
			break;
		default:
			require 'models/error/invalid_action.php';
	}
} elseif ($request_method == 'POST') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'sign-in':
			require 'models/login/sign_in.php';
	}
}