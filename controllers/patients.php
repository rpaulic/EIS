<?php

if ($request_method == 'GET') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'index':
			require 'models/patient/index.php';
			loadView($controller, $action, 'Popis pacijenata', array('patients' => $results));
			break;
		case 'new':
			loadView($controller, $action, 'Novi pacijent', array(), true);
			break;
		case 'show':
			require 'models/patient/show.php';
			loadView($controller, $action, 'Pregled pacijenta', array('patient' => $patient, 'medical_records' => $medical_records));
			break;
		case 'edit':
			require 'models/patient/edit.php';
			loadView($controller, $action, 'Uređivanje pacijenta', array('patient' => $result), true);
			break;
		case 'delete':
			require 'models/patient/delete.php';
			loadView($controller, $action, 'Brisanje pacijenta', array('patient' => $result), true);
			break;
		default:
			require 'models/error/invalid_action.php';
	}
} elseif ($request_method == 'POST') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'create':
			require 'models/patient/create.php';
			break;
		case 'update':
			require 'models/patient/update.php';
			break;
		case 'destroy':
			require 'models/patient/destroy.php';
	}
}