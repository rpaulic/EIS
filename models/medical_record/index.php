<?php

// Filter the data, if requested.
if ($filter) {
	$query = "SELECT *
			  FROM medical_record
			  WHERE is_deleted = 0
			  AND (document_uid    = :document_uid OR
			  	   document_series = :document_series OR
			  	   document_date   = STR_TO_DATE(:document_date, '%d/%m/%Y') OR
			  	   patient_code    = :patient_code OR
			  	   patient_full_name LIKE CONCAT('%', :patient_full_name, '%'))
			  ORDER BY document_uid DESC";

	$params = array(
		':document_uid'      => $filter,
		':document_series'   => $filter,
		':document_date'     => $filter,
		':patient_code'      => $filter,
		':patient_full_name' => $filter,
	);
} else {
	$query = 'SELECT *
			  FROM medical_record
			  WHERE is_deleted = 0
			  ORDER BY document_uid DESC';
	
	$params = array();
}

// Prepare and execute the SQL statement.
$sth = $dbh->prepare($query);
$sth->execute($params);

// Fetch the results.
$results = $sth->fetchAll(PDO::FETCH_ASSOC);