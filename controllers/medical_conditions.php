<?php

if ($request_method == 'GET') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'index':
			require 'models/medical_condition/index.php';
			loadView($controller, $action, 'Popis zdravstvenih problema', array('medical_conditions' => $results));
			break;
		case 'new':
			loadView($controller, $action, 'Novi zdravstveni problem', array(), true);
			break;
		case 'show':
			require 'models/medical_condition/show.php';
			loadView($controller, $action, 'Pregled zdravstvenog problema', array('medical_condition' => $result));
			break;
		case 'edit':
			require 'models/medical_condition/edit.php';
			loadView($controller, $action, 'Uređivanje zdravstvenog problema', array('medical_condition' => $result), true);
			break;
		case 'delete':
			require 'models/medical_condition/delete.php';
			loadView($controller, $action, 'Brisanje zdravstvenog problema', array('medical_condition' => $result), true);
			break;
		default:
			require 'models/error/invalid_action.php';
	}
} elseif ($request_method == 'POST') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'create':
			require 'models/medical_condition/create.php';
			break;
		case 'update':
			require 'models/medical_condition/update.php';
			break;
		case 'destroy':
			require 'models/medical_condition/destroy.php';
	}
}