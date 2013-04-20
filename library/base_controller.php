<?php

// Redirect to the Login controller if the user is not logged in.
if (!$logged_in && $controller != 'login') {
	header('Location: /login');
	exit;
}

// Load the appropriate controller.
switch ($controller) {
	case 'login':
		require 'controllers/login.php';
		break;
	case 'index':
		require 'controllers/index.php';
		break;
	case 'patients':
		require 'controllers/patients.php';
		break;
	case 'medical-conditions':
		require 'controllers/medical_conditions.php';
		break;
	case 'treatments':
		require 'controllers/treatments.php';
		break;
	case 'medical-records':
		require 'controllers/medical_records.php';
		break;
	case 'about':
		require 'controllers/about.php';
		break;
	default:
		require 'models/error/invalid_controller.php';
}