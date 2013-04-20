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
	$code = gInternalCode('treatment', 'T');

	$query = 'INSERT INTO treatment
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

	$treatment_id = $dbh->lastInsertId();

	$_SESSION['flash'] = 'Terapija je uspješno sačuvana.';

	// Successful creation.
	$header_location = '/treatments/show/' . $treatment_id;
} else {
	$_SESSION['flash'] = 'Nije moguće sačuvati terapiju!';
	$_SESSION['errors'] = $errors;
	$_SESSION['form_values'] = $_POST;

	// Unsuccessful creation.
	$header_location = '/treatments/new';
}

// Redirect on completion.
header('Location: ' . $header_location);
exit;