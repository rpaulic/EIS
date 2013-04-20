<?php

// Validate the CSRF token.
validateCSRFToken($controller, 'edit');

// Get the posted values.
$patient_id = $_POST['patient_id'];
$first_name = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$full_name  = $first_name . ' ' . $last_name;
$gender     = $_POST['gender'];
$birthdate  = $_POST['birthdate'];

$oib          = ($_POST['oib'])          ?: null;
$address      = ($_POST['address'])      ?: null;
$postal_code  = ($_POST['postal_code'])  ?: null;
$location     = ($_POST['location'])     ?: null;
$phone_number = ($_POST['phone_number']) ?: null;
$email        = ($_POST['email'])        ?: null;

// Check if the patient is deleted.
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
	header('Location: /patients/');
	exit;
}

// Validate the FIRST_NAME field.
if (!$first_name)
	$errors[] = 'Ime - obavezno polje.';
elseif (strlen($first_name) > 32)
	$errors[] = 'Ime - maksimalno 32 znaka.';

// Validate the LAST_NAME field.
if (!$last_name)
	$errors[] = 'Prezime - obavezno polje.';
elseif (strlen($last_name) > 32)
	$errors[] = 'Prezime - maksimalno 32 znaka.';

// Validate the BIRTHDATE field.
if (!$birthdate) {
	$errors[] = 'Datum rođenja - obavezno polje.';
} else {
	if (!preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $birthdate, $date_parts)) {
		$errors[] = 'Neispravan datum rođenja.';
	} else {
		if (!checkdate($date_parts[2], $date_parts[1], $date_parts[3])) {
			$errors[] = 'Neispravan datum rođenja.';
		} else {
			$birthdate = $date_parts[3] . '-' . $date_parts[2] . '-' . $date_parts[1];
		}
	}
}

// Validate the OIB field.
if ($oib) {
	if (strlen($oib) != 11) {
		$errors[] = 'OIB - točno 11 znakova.';
	} else {
		$query = 'SELECT *
				  FROM patient
				  WHERE is_deleted = 0
				  AND patient_id <> :patient_id
				  AND oib = :oib';
		
		$params = array(
			':patient_id' => $patient_id,
			':oib'        => $oib,
		);

		$sth = $dbh->prepare($query);
		$sth->execute($params);
		$result = $sth->fetch(PDO::FETCH_ASSOC);

		if ($result) $errors[] = 'OIB je zauzet.';
	}
}

// Validate the ADDRESS field.
if ($address) {
	if (strlen($address) > 64) $errors[] = 'Adresa - maksimalno 64 znaka.';
}

// Validate the POSTAL_CODE field.
if ($postal_code) {
	$postal_code = (int) $postal_code;

	if ($postal_code < 10000 || $postal_code > 54000) $errors[] = 'Neispravan poštanski broj.';
}

// Validate the LOCATION field.
if ($location) {
	if (strlen($location) > 64) $errors[] = 'Mjesto - maksimalno 64 znaka.';
}

// Validate the PHONE_NUMBER field.
if ($phone_number) {
	if (strlen($phone_number) > 16) $errors[] = 'Telefonski broj - maksimalno 16 znakova.';
}

// Validate the EMAIL field.
if ($email) {
	if (strlen($email) > 64) {
		$errors[] = 'Email - maksimalno 64 znaka.';
	} else {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Neispravna email adresa.';
		} else {
			$query = 'SELECT *
					  FROM patient
					  WHERE is_deleted = 0
					  AND patient_id <> :patient_id
					  AND email = :email';
		
			$params = array(
				':patient_id' => $patient_id,
				':email'      => $email,
			);

			$sth = $dbh->prepare($query);
			$sth->execute($params);
			$result = $sth->fetch(PDO::FETCH_ASSOC);

			if ($result) $errors[] = 'Email adresa je zauzeta.';
		}
	}
}

// Process the form submission.
if (!$errors) {
	$query = 'UPDATE patient
			  SET first_name   = :first_name
			  	 ,last_name    = :last_name
			  	 ,full_name    = :full_name
			  	 ,gender       = :gender
			  	 ,birthdate    = :birthdate
			  	 ,oib          = :oib
			  	 ,address      = :address
			  	 ,postal_code  = :postal_code
			  	 ,location     = :location
			  	 ,phone_number = :phone_number
			  	 ,email        = :email
			  WHERE patient_id = :patient_id';
	
	$params = array(
		':first_name'   => $first_name,
		':last_name'    => $last_name,
		':full_name'    => $full_name,
		':gender'       => $gender,
		':birthdate'    => $birthdate,
		':oib'          => $oib,
		':address'      => $address,
		':postal_code'  => $postal_code,
		':location'     => $location,
		':phone_number' => $phone_number,
		':email'        => $email,
		':patient_id'   => $patient_id,
	);

	// Prepare and execute the SQL statement.
	$sth = $dbh->prepare($query);
	$sth->execute($params);

	$_SESSION['flash'] = 'Promjene su uspješno sačuvane.';

	// Successful updating.
	$header_location = '/patients/show/' . $patient_id;
} else {
	$_SESSION['flash'] = 'Nije moguće sačuvati promjene!';
	$_SESSION['errors'] = $errors;
	$_SESSION['form_values'] = $_POST;

	// Unsuccessful updating.
	$header_location = '/patients/edit/' . $patient_id;
}

// Redirect on completion.
header('Location: ' . $header_location);
exit;