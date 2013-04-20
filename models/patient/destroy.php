<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'delete');

// Get the posted values.
$patient_id = $_POST['patient_id'];

// Check if the patient is deleted.
$query = 'SELECT *
		  FROM patient
		  WHERE is_deleted = 0
		  AND patient_id = :patient_id';

$params = array(
	':patient_id' => $patient_id,
);

$sth = $dbh->prepare($query);
$sth->execute($params);
$result = $sth->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	$_SESSION['flash'] = 'Nevažeći pacijent!';
	header('Location: /patients/');
	exit;
}

// Process deletion.
$query = 'UPDATE patient
		  SET is_deleted = 1
		  WHERE patient_id = :patient_id';

$params = array(
	':patient_id' => $patient_id,
);

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

$_SESSION['flash'] = 'Pacijent je uspješno obrisan.';

// Redirect on completion.
header('Location: /patients/');
exit;