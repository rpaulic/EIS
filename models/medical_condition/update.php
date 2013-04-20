<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'edit');

// Get the posted values.
$medical_condition_id = $_POST['medical_condition_id'];
$title                = $_POST['title'];
$type                 = $_POST['type'];

$description = ($_POST['description']) ?: null;

// Check if the medical condition is deleted.
$query = 'SELECT *
		  FROM medical_condition
		  WHERE is_deleted = 0
		  AND medical_condition_id = :medical_condition_id';

$params = array(
	':medical_condition_id' => $medical_condition_id,
);

$sth = $dbh->prepare($query);
$sth->execute($params);
$result = $sth->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	$_SESSION['flash'] = 'Nevažeći zdravstveni problem!';
	header('Location: /medical-conditions/');
	exit;
}

// Validate the TITLE field.
if (!$title)
	$errors[] = 'Naziv - obavezno polje.';
elseif (strlen($title) > 128)
	$errors[] = 'Naziv - maksimalno 128 znakova.';

// Process the form submission.
if (!$errors) {
	$query = 'UPDATE medical_condition
			  SET title       = :title
			  	 ,type        = :type
			  	 ,description = :description
			  WHERE medical_condition_id = :medical_condition_id';
	
	$params = array(
		':title'                => $title,
		':type'                 => $type,
		':description'          => $description,
		':medical_condition_id' => $medical_condition_id,
	);

	// Prepare and execute the SQL statement.
	$sth = $dbh->prepare($query);
	$sth->execute($params);

	$_SESSION['flash'] = 'Promjene su uspješno sačuvane.';

	// Successful updating.
	$header_location = '/medical-conditions/show/' . $medical_condition_id;
} else {
	$_SESSION['flash'] = 'Nije moguće sačuvati promjene!';
	$_SESSION['errors'] = $errors;
	$_SESSION['form_values'] = $_POST;

	// Unsuccessful updating.
	$header_location = '/medical-conditions/edit/' . $medical_condition_id;
}

// Redirect on completion.
header('Location: ' . $header_location);
exit;