<?php

// Filter the data, if requested.
if ($filter) {
	$query = "SELECT *
			  FROM patient
			  WHERE is_deleted = 0
			  AND (code = :code OR full_name LIKE CONCAT('%', :full_name, '%'))
			  ORDER BY code ASC";

	$params = array(
		':code'      => $filter,
		':full_name' => $filter,
	);
} else {
	$query = 'SELECT *
			  FROM patient
			  WHERE is_deleted = 0
			  ORDER BY code ASC';
	
	$params = array();
}

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

// Fetch the results.
$results = $sth->fetchAll(PDO::FETCH_ASSOC);