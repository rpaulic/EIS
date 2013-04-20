<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'edit');

// Get the posted values.
$treatment_id = $_POST['treatment_id'];
$title        = $_POST['title'];
$type         = $_POST['type'];

$description = ($_POST['description']) ?: null;

// Check if the treatment is deleted.
$query = 'SELECT *
		  FROM treatment
		  WHERE is_deleted = 0
		  AND treatment_id = :treatment_id';

$params = array(
	':treatment_id' => $treatment_id,
);

$sth = $dbh->prepare($query);
$sth->execute($params);
$result = $sth->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	$_SESSION['flash'] = 'Nevažeća terapija!';
	header('Location: /treatments/');
	exit;
}

// Validate the TITLE field.
if (!$title)
	$errors[] = 'Naziv - obavezno polje.';
elseif (strlen($title) > 128)
	$errors[] = 'Naziv - maksimalno 128 znakova.';

// Process the form submission.
if (!$errors) {
	$query = 'UPDATE treatment
			  SET title       = :title
			  	 ,type        = :type
			  	 ,description = :description
			  WHERE treatment_id = :treatment_id';
	
	$params = array(
		':title'        => $title,
		':type'         => $type,
		':description'  => $description,
		':treatment_id' => $treatment_id,
	);

	// Prepare and execute the SQL statement.
	$sth = $dbh->prepare($query);
	$sth->execute($params);

	$_SESSION['flash'] = 'Promjene su uspješno sačuvane.';

	// Successful updating.
	$header_location = '/treatments/show/' . $treatment_id;
} else {
	$_SESSION['flash'] = 'Nije moguće sačuvati promjene!';
	$_SESSION['errors'] = $errors;
	$_SESSION['form_values'] = $_POST;

	// Unsuccessful updating.
	$header_location = '/treatments/edit/' . $treatment_id;
}

// Redirect on completion.
header('Location: ' . $header_location);
exit;