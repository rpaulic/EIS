<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'print');

// Get the posted values.
$medical_record_id = $_POST['medical_record_id'];

// Check if the document is deleted.
$query = 'SELECT *
		  FROM medical_record
		  WHERE is_deleted = 0
		  AND medical_record_id = :medical_record_id';

$params = array(
	':medical_record_id' => $medical_record_id,
);

$sth = $dbh->prepare($query);
$sth->execute($params);
$result = $sth->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	$_SESSION['flash'] = 'Nevažeći zapis!';
	header('Location: /medical-records/');
	exit;
}

// Update document.
if ($result['is_printed'] == 'Ne') {
	$query = "UPDATE medical_record
			  SET is_printed  = 'Da'
			  WHERE medical_record_id = :medical_record_id";

	$params = array(
		':medical_record_id' => $medical_record_id,
	);

	$sth = $dbh->prepare($query);
	$sth->execute($params);
}

if ($result['is_locked'] == 'Ne') {
	$query = "UPDATE medical_record
			  SET is_locked  = 'Da'
			  WHERE medical_record_id = :medical_record_id";

	$params = array(
		':medical_record_id' => $medical_record_id,
	);

	$sth = $dbh->prepare($query);
	$sth->execute($params);
}

// Output the PDF version of the document.
require 'views/medical_records/output.pdf.php';