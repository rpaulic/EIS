<?php

if ($request_method == 'GET') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'index':
			require 'models/treatment/index.php';
			loadView($controller, $action, 'Popis terapija', array('treatments' => $results));
			break;
		case 'new':
			loadView($controller, $action, 'Nova terapija', array(), true);
			break;
		case 'show':
			require 'models/treatment/show.php';
			loadView($controller, $action, 'Pregled terapije', array('treatment' => $result));
			break;
		case 'edit':
			require 'models/treatment/edit.php';
			loadView($controller, $action, 'Uređivanje terapije', array('treatment' => $result), true);
			break;
		case 'delete':
			require 'models/treatment/delete.php';
			loadView($controller, $action, 'Brisanje terapije', array('treatment' => $result), true);
			break;
		default:
			require 'models/error/invalid_action.php';
	}
} elseif ($request_method == 'POST') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'create':
			require 'models/treatment/create.php';
			break;
		case 'update':
			require 'models/treatment/update.php';
			break;
		case 'destroy':
			require 'models/treatment/destroy.php';
	}
}