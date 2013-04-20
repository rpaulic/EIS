<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'edit');

// Get the posted values.
$medical_record_id = $_POST['medical_record_id'];
$patient_id        = $_POST['patient_id'];

$anamnesis      = ($_POST['anamnesis'])      ?: null;
$examination    = ($_POST['examination'])    ?: null;
$diagnosis      = ($_POST['diagnosis'])      ?: null;
$therapy        = ($_POST['therapy'])        ?: null;
$recommendation = ($_POST['recommendation']) ?: null;

// Check if the document is deleted.
$query = 'SELECT *
		  FROM medical_record
		  WHERE is_deleted = 0
		  AND medical_record_id = :medical_record_id';

$params = array(
	':medical_record_id' => $medical_record_id,
);

$sth = $dbh->prepare($query);
$sth->execute($params);
$medical_record = $sth->fetch(PDO::FETCH_ASSOC);

if (!$medical_record) {
	$_SESSION['flash'] = 'Nevažeći zapis!';
	header('Location: /medical-records/');
	exit;
}

// Check if the document is locked.
if ($medical_record['is_locked'] == 'Da') {
	$_SESSION['flash'] = 'Zaključani zapis nije moguće uređivati!';
	header('Location: /medical-records/');
	exit;
}

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
	$document_date = gMedicalRecord('date');

	if ($patient_id !== $medical_record['patient_id']) {
		$document_series = gMedicalRecord('series', $patient_id);
		$document_number = gMedicalRecord('number', $patient_id);
	} else {
		$document_series = $medical_record['document_series'];
		$document_number = $medical_record['document_number'];
	}

	$query = 'UPDATE medical_record
			  SET document_series   = :document_series
			     ,document_number   = :document_number
			     ,document_date     = :document_date
			  	 ,patient_id        = :patient_id
			  	 ,patient_code      = :patient_code
			  	 ,patient_full_name = :patient_full_name
			  	 ,patient_gender    = :patient_gender
			  	 ,patient_age       = :patient_age
			  	 ,anamnesis         = :anamnesis
			  	 ,examination       = :examination
			  	 ,diagnosis         = :diagnosis
			  	 ,therapy           = :therapy
			  	 ,recommendation    = :recommendation
			  WHERE medical_record_id = :medical_record_id';
	
	$params = array(
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
		':medical_record_id' => $medical_record_id,
	);

	// Prepare and execute the SQL statement.
	$sth = $dbh->prepare($query);
	$sth->execute($params);

	$_SESSION['flash'] = 'Promjene su uspješno sačuvane.';

	// Successful updating.
	$header_location = '/medical-records/show/' . $medical_record_id;
} else {
	$_SESSION['flash'] = 'Nije moguće sačuvati promjene!';
	$_SESSION['errors'] = $errors;
	$_SESSION['form_values'] = $_POST;

	// Unsuccessful updating.
	$header_location = '/medical-records/edit/' . $medical_record_id;
}

// Redirect on completion.
header('Location: ' . $header_location);
exit;