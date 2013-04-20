<?php

if ($request_method == 'GET') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'index':
			require 'models/medical_record/index.php';
			loadView($controller, $action, 'Popis zapisa', array('medical_records' => $results));
			break;
		case 'new':
			require 'models/medical_record/new.php';
			loadView($controller, $action, 'Novi zapis', array('patients' => $results), true);
			break;
		case 'show':
			require 'models/medical_record/show.php';
			loadView($controller, $action, 'Pregled zapisa', array('medical_record' => $result));
			break;
		case 'edit':
			require 'models/medical_record/edit.php';
			loadView($controller, $action, 'Uređivanje zapisa', array('medical_record' => $medical_record, 'patients' => $patients), true);
			break;
		case 'delete':
			require 'models/medical_record/delete.php';
			loadView($controller, $action, 'Brisanje zapisa', array('medical_record' => $result), true);
			break;
		case 'print':
			require 'models/medical_record/print.php';
			loadView($controller, $action, 'Ispis zapisa', array('medical_record' => $result), true);
			break;
		default:
			require 'models/error/invalid_action.php';
	}
} elseif ($request_method == 'POST') {
	// Invoke the appropriate action.
	switch ($action) {
		case 'create':
			require 'models/medical_record/create.php';
			break;
		case 'update':
			require 'models/medical_record/update.php';
			break;
		case 'destroy':
			require 'models/medical_record/destroy.php';
			break;
		case 'output';
			require 'models/medical_record/output.php';
	}
}