<?php

// Generates the CSRF token.
function generateCSRFToken($controller, $action)
{
	$source = $controller . '-' . $action;

	$_SESSION[$source]['csrf_token'] = $token = sha1(microtime());

	return $token;
}

// Validates the CSRF token.
function validateCSRFToken($controller, $action)
{
	$source = $controller . '-' . $action;

	$session_token = (!empty($_SESSION[$source]['csrf_token'])) ? $_SESSION[$source]['csrf_token'] : false;
	$form_token    = (!empty($_POST['csrf_token']))             ? $_POST['csrf_token']             : false;

	if ($session_token !== $form_token) {
		echo 'CSRF napad!';
		exit;
	}

	return;
}

// Loads the default template file and a given view file.
function loadView($controller, $action, $page_title, $data = array(), $csrf_token = false)
{
	global $flash, $errors, $logged_in;

	// Generate the CSRF token, if needed.
	$csrf_token = ($csrf_token) ? generateCSRFToken($controller, $action) : null;

	// Load the model data.
	extract($data);

	// Load the requested view.
	ob_start();
	require 'views/' . str_replace('-', '_', $controller) . '/' . $action . '.php';
	$view_contents = ob_get_clean();

	// Set the page title.
	$page_title = $page_title;

	// Load the default template.
	require 'views/template.php';

	return;
}

// Repopulates the form fields when editing an entry.
function rFormOnEdit($data, $field_name, $field_value = null, $select_element = false)
{
	global $repopulate_form;

	// Invoke rFormOnError when an invalid submission takes place.
	if ($repopulate_form) return rFormOnError($field_name, $field_value, $select_element);

	// Return value for the HTML select element.
	if ($select_element) {
		if ($data[$field_name] == $field_value)
			return 'selected';
		else
			return null;
	}

	// Special case: date field.
	if ($field_name == 'birthdate') return formatDate($data[$field_name]);

	// Return value for the HTML input element.
	return h($data[$field_name]);
}

// Repopulates the form fields on an invalid submission.
function rFormOnError($field_name, $field_value = null, $select_element = false)
{
	global $repopulate_form;

	if (!$repopulate_form) return null;

	// Return value for the HTML select element.
	if ($select_element) {
		if ($repopulate_form[$field_name] == $field_value)
			return 'selected';
		else
			return null;
	}

	// Return value for the HTML input element.
	return h($repopulate_form[$field_name]);
}

// Converts special characters to HTML entities.
function h($string)
{
	return htmlspecialchars($string);
}

// Returns the formatted date string.
function formatDate($field_name = null, $format = 'd/m/Y')
{
	$date = new DateTime($field_name);

	return $date->format($format);
}

// Generates internal code.
function gInternalCode($table_name, $prefix)
{
	global $dbh;

	$query = "SELECT IFNULL(MAX(SUBSTRING(code, 2)), 0) AS code
			  FROM $table_name";
	
	$params = array();

	$sth = $dbh->prepare($query);
	$sth->execute($params);
	$result = $sth->fetch(PDO::FETCH_ASSOC);

	// Process result.
	$code = (int) $result['code'] + 1;
	$code = str_pad($code, 4, '0', STR_PAD_LEFT);
	$code = $prefix . $code;

	return $code;
}

// Generates document information.
function gMedicalRecord($field_name, $patient_id = null)
{
	global $dbh;

	switch ($field_name) {
		// Unique document number.
		case 'uid':
			$query = 'SELECT IFNULL(MAX(document_uid), 0) + 1 AS document_uid
					  FROM medical_record';
			
			$params = array();

			$sth = $dbh->prepare($query);
			$sth->execute($params);
			$result = $sth->fetch(PDO::FETCH_ASSOC);

			return $result['document_uid'];
		// Document series.
		case 'series':
			$query = 'SELECT code
					  FROM patient
					  WHERE patient_id = :patient_id';
			
			$params = array(
				':patient_id' => $patient_id,
			);

			$sth = $dbh->prepare($query);
			$sth->execute($params);
			$result = $sth->fetch(PDO::FETCH_ASSOC);

			return formatDate(null, 'Y') . '/' . $result['code'];
		// Document number inside a series.
		case 'number':
			$document_series = gMedicalRecord('series', $patient_id);

			$query = 'SELECT IFNULL(MAX(document_number), 0) + 1 AS document_number
					  FROM medical_record
					  WHERE document_series = :document_series';
			
			$params = array(
				':document_series' => $document_series,
			);

			$sth = $dbh->prepare($query);
			$sth->execute($params);
			$result = $sth->fetch(PDO::FETCH_ASSOC);

			return $result['document_number'];
		// Document date.
		case 'date':
			return formatDate(null, 'Y-m-d');
		default:
			return null;
	}
}

// Pads a string to a certain length with '0'.
function padString($string, $times)
{
	return str_pad($string, $times, '0', STR_PAD_LEFT);
}