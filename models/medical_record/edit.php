<?php

// Redirect to the Medical records controller if the ID is not provided.
if (!$id) {
	$_SESSION['flash'] = 'Nedopuštena radnja!';
	header('Location: /medical-records/');
	exit;
}

$query = 'SELECT *
		  FROM medical_record
		  WHERE is_deleted = 0
		  AND medical_record_id = :medical_record_id';

$params = array(
	':medical_record_id' => $id,
);

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

// Fetch the result.
$medical_record = $sth->fetch(PDO::FETCH_ASSOC);

// Redirect to the Medical records controller if an invalid ID is provided.
if (!$medical_record) {
	$_SESSION['flash'] = 'Nevažeći zapis!';
	header('Location: /medical-records/');
	exit;
}

// Redirect to the Medical records controller if the document is locked.
if ($medical_record['is_locked'] == 'Da') {
	$_SESSION['flash'] = 'Zaključani zapis nije moguće uređivati!';
	header('Location: /medical-records/');
	exit;
}

// Fetch all patients.
$query = 'SELECT *
		  FROM patient
		  WHERE is_deleted = 0
		  ORDER BY full_name ASC';

$params = array();

$sth = $dbh->prepare($query);
$sth->execute($params);
$patients = $sth->fetchAll(PDO::FETCH_ASSOC);