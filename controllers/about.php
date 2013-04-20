<?php

if ($request_method == 'GET') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'index':
			loadView($controller, $action, 'O nama');
			break;
		default:
			require 'models/error/invalid_action.php';
	}
}