<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'delete');

// Get the posted values.
$treatment_id = $_POST['treatment_id'];

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

// Process deletion.
$query = 'UPDATE treatment
		  SET is_deleted = 1
		  WHERE treatment_id = :treatment_id';

$params = array(
	':treatment_id' => $treatment_id,
);

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

$_SESSION['flash'] = 'Terapija je uspješno obrisana.';

// Redirect on completion.
header('Location: /treatments/');
exit;