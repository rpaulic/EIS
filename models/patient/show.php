<?php

// Redirect to the Patients controller if the ID is not provided.
if (!$id) {
	$_SESSION['flash'] = 'Nedopuštena radnja!';
	header('Location: /patients/');
	exit;
}

$query = 'SELECT *
		  FROM patient
		  WHERE is_deleted = 0
		  AND patient_id = :patient_id';

$params = array(
	':patient_id' => $id,
);

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

// Fetch the result.
$patient = $sth->fetch(PDO::FETCH_ASSOC);

// Redirect to the Patients controller if an invalid ID is provided.
if (!$patient) {
	$_SESSION['flash'] = 'Nevažeći pacijent!';
	header('Location: /patients/');
	exit;
}

// Fetch all medical records.
$query = 'SELECT *
		  FROM medical_record
		  WHERE is_deleted = 0
		  AND patient_id = :patient_id
		  ORDER BY document_uid DESC';

$params = array(
	':patient_id' => $id
);

$sth = $dbh->prepare($query);
$sth->execute($params);
$medical_records = $sth->fetchAll(PDO::FETCH_ASSOC);