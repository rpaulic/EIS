<?php

// Redirect to the Treatments controller if the ID is not provided.
if (!$id) {
	$_SESSION['flash'] = 'Nedopuštena radnja!';
	header('Location: /treatments/');
	exit;
}

$query = 'SELECT *
		  FROM treatment
		  WHERE is_deleted = 0
		  AND treatment_id = :treatment_id';

$params = array(
	':treatment_id' => $id,
);

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

// Fetch the result.
$result = $sth->fetch(PDO::FETCH_ASSOC);

// Redirect to the Treatments controller if an invalid ID is provided.
if (!$result) {
	$_SESSION['flash'] = 'Nevažeća terapija!';
	header('Location: /treatments/');
	exit;
}