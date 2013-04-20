<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'new');

// Get the posted values.
$title = $_POST['title'];
$type  = $_POST['type'];

$description = ($_POST['description']) ?: null;

// Validate the TITLE field.
if (!$title)
	$errors[] = 'Naziv - obavezno polje.';
elseif (strlen($title) > 128)
	$errors[] = 'Naziv - maksimalno 128 znakova.';

// Process the form submission.
if (!$errors) {
	// Generate internal code.
	$code = gInternalCode('medical_condition', 'Z');

	$query = 'INSERT INTO medical_condition
			  (code
			  ,title
			  ,type
			  ,description)
			  VALUES
			  (:code
			  ,:title
			  ,:type
			  ,:description)';
	
	$params = array(
		':code'        => $code,
		':title'       => $title,
		':type'        => $type,
		':description' => $description,
	);

	// Prepare and execute the SQL statement.
	$sth = $dbh->prepare($query);
	$sth->execute($params);

	$medical_condition_id = $dbh->lastInsertId();

	$_SESSION['flash'] = 'Zdravstveni problem je uspješno sačuvan.';

	// Successful creation.
	$header_location = '/medical-conditions/show/' . $medical_condition_id;
} else {
	$_SESSION['flash'] = 'Nije moguće sačuvati zdravstveni problem!';
	$_SESSION['errors'] = $errors;
	$_SESSION['form_values'] = $_POST;

	// Unsuccessful creation.
	$header_location = '/medical-conditions/new';
}

// Redirect on completion.
header('Location: ' . $header_location);
exit;