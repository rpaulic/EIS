<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'delete');

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

// Check if the document is locked.
if ($result['is_locked'] == 'Da') {
	$_SESSION['flash'] = 'Zaključani zapis nije moguće obrisati!';
	header('Location: /medical-records/');
	exit;
}

// Process deletion.
$query = 'UPDATE medical_record
		  SET is_deleted = 1
		  WHERE medical_record_id = :medical_record_id';

$params = array(
	':medical_record_id' => $medical_record_id,
);

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

$_SESSION['flash'] = 'Zapis je uspješno obrisan.';

// Redirect on completion.
header('Location: /medical-records/');
exit;