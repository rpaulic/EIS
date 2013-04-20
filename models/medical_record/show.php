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
$result = $sth->fetch(PDO::FETCH_ASSOC);

// Redirect to the Medical records controller if an invalid ID is provided.
if (!$result) {
	$_SESSION['flash'] = 'Nevažeći zapis!';
	header('Location: /medical-records/');
	exit;
}