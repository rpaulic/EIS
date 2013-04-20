<?php

// Filter the data, if requested.
if ($filter) {
	$query = "SELECT *
			  FROM medical_condition
			  WHERE is_deleted = 0
			  AND (code = :code OR
			  	   type = :type OR
			  	   title LIKE CONCAT('%', :title, '%'))
			  ORDER BY code ASC";

	$params = array(
		':code'  => $filter,
		':type'  => $filter,
		':title' => $filter,
	);
} else {
	$query = 'SELECT *
			  FROM medical_condition
			  WHERE is_deleted = 0
			  ORDER BY code ASC';
	
	$params = array();
}

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

// Fetch the results.
$results = $sth->fetchAll(PDO::FETCH_ASSOC);