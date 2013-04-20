<?php

// Redirect to the Medical conditions controller if the ID is not provided.
if (!$id) {
	$_SESSION['flash'] = 'Nedopuštena radnja!';
	header('Location: /medical-conditions/');
	exit;
}

$query = 'SELECT *
		  FROM medical_condition
		  WHERE is_deleted = 0
		  AND medical_condition_id = :medical_condition_id';

$params = array(
	':medical_condition_id' => $id,
);

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

// Fetch the result.
$result = $sth->fetch(PDO::FETCH_ASSOC);

// Redirect to the Medical conditions controller if an invalid ID is provided.
if (!$result) {
	$_SESSION['flash'] = 'Nevažeći zdravstveni problem!';
	header('Location: /medical-conditions/');
	exit;
}