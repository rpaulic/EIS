<?php

// Get the posted values.
$user     = $_POST['user'];
$password = $_POST['password'];

// Validate the USER field.
if (!$user)
	$errors[] = 'Korisnik - obavezno polje.';
elseif ($user != APPLICATION_USER)
	$errors[] = 'Neispravno korisničko ime.';

// Validate the PASSWORD field.
if (!$password)
	$errors[] = 'Zaporka - obavezno polje.';
elseif ($password != APPLICATION_PASSWORD)
	$errors[] = 'Neispravna zaporka.';

// Validate given credentials.
if (!$errors) {
	// Update the current session ID.
	session_regenerate_id();

	$_SESSION['logged_in'] = true;
	$_SESSION['flash'] = 'Uspješno ste se prijavili.';

	// Successful sign in.
	$header_location = '/';
} else {
	$_SESSION['flash'] = 'Neuspješna prijava!';
	$_SESSION['errors'] = $errors;
	$_SESSION['form_values'] = $_POST;

	// Unsuccessful sign in.
	$header_location = '/login';
}

// Redirect on completion.
header('Location: ' . $header_location);
exit;