<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'new');

// Get the posted values.
$patient_id = $_POST['patient_id'];

$anamnesis      = ($_POST['anamnesis'])      ?: null;
$examination    = ($_POST['examination'])    ?: null;
$diagnosis      = ($_POST['diagnosis'])      ?: null;
$therapy        = ($_POST['therapy'])        ?: null;
$recommendation = ($_POST['recommendation']) ?: null;

// Validate the PATIENT_ID field.
$query = 'SELECT *
		  FROM patient
		  WHERE is_deleted = 0
		  AND patient_id = :patient_id';

$params = array(
	':patient_id' => $patient_id,
);

$sth = $dbh->prepare($query);
$sth->execute($params);
$result = $sth->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	$_SESSION['flash'] = 'Nevažeći pacijent!';
	header('Location: /medical-records/');
	exit;
} else {
	$current_date = new DateTime();
	$birthdate = DateTime::createFromFormat('Y-m-d', $result['birthdate']);

	$patient_code      = $result['code'];
	$patient_full_name = $result['full_name'];
	$patient_gender    = $result['gender'];
	$patient_age       = $current_date->diff($birthdate)->y;
}

// Validate document content.
if (!$anamnesis && !$examination && !$diagnosis && !$therapy && !$recommendation)
	$errors[] = 'Nije moguće sačuvati prazan dokument.';

// Process the form submission.
if (!$errors) {
	// Generate document information.
	$document_uid    = gMedicalRecord('uid');
	$document_series = gMedicalRecord('series', $patient_id);
	$document_number = gMedicalRecord('number', $patient_id);
	$document_date   = gMedicalRecord('date');

	$query = 'INSERT INTO medical_record
			  (document_uid
			  ,document_series
			  ,document_number
			  ,document_date
			  ,patient_id
			  ,patient_code
			  ,patient_full_name
			  ,patient_gender
			  ,patient_age
			  ,anamnesis
			  ,examination
			  ,diagnosis
			  ,therapy
			  ,recommendation)
			  VALUES
			  (:document_uid
			  ,:document_series
			  ,:document_number
			  ,:document_date
			  ,:patient_id
			  ,:patient_code
			  ,:patient_full_name
			  ,:patient_gender
			  ,:patient_age
			  ,:anamnesis
			  ,:examination
			  ,:diagnosis
			  ,:therapy
			  ,:recommendation)';
	
	$params = array(
		':document_uid'      => $document_uid,
		':document_series'   => $document_series,
		':document_number'   => $document_number,
		':document_date'     => $document_date,
		':patient_id'        => $patient_id,
		':patient_code'      => $patient_code,
		':patient_full_name' => $patient_full_name,
		':patient_gender'    => $patient_gender,
		':patient_age'       => $patient_age,
		':anamnesis'         => $anamnesis,
		':examination'       => $examination,
		':diagnosis'         => $diagnosis,
		':therapy'           => $therapy,
		':recommendation'    => $recommendation,
	);

	// Prepare and execute the SQL statement.
	$sth = $dbh->prepare($query);
	$sth->execute($params);

	$medical_record_id = $dbh->lastInsertId();

	$_SESSION['flash'] = 'Zapis je uspješno sačuvan.';

	// Successful creation.
	$header_location = '/medical-records/show/' . $medical_record_id;
} else {
	$_SESSION['flash'] = 'Nije moguće sačuvati zapis!';
	$_SESSION['errors'] = $errors;
	$_SESSION['form_values'] = $_POST;

	// Unsuccessful creation.
	$header_location = '/medical-records/new';
}

// Redirect on completion.
header('Location: ' . $header_location);
exit;