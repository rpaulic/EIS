<?php

$query = 'SELECT *
		  FROM patient
		  WHERE is_deleted = 0
		  ORDER BY full_name ASC';

$params = array();

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

// Fetch the results.
$results = $sth->fetchAll(PDO::FETCH_ASSOC);

// Redirect to the Medical records controller if there are no patients in the database.
if (!$results) {
	$_SESSION['flash'] = 'Ne postoji niti jedan pacijent! <a href="/patients/new" style="color: White;">Novi pacijent.</a>';
	header('Location: /medical-records/');
	exit;
}