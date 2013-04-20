<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'delete');

// Get the posted values.
$medical_condition_id = $_POST['medical_condition_id'];

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

// Process deletion.
$query = 'UPDATE medical_condition
		  SET is_deleted = 1
		  WHERE medical_condition_id = :medical_condition_id';

$params = array(
	':medical_condition_id' => $medical_condition_id,
);

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

$_SESSION['flash'] = 'Zdravstveni problem je uspješno obrisan.';

// Redirect on completion.
header('Location: /medical-conditions/');
exit;