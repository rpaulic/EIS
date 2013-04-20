<?php

// Flash message.
if (!empty($_SESSION['flash'])) {
	$flash = $_SESSION['flash'];
	unset($_SESSION['flash']);
} else {
	$flash = false;
}

// Error messages.
if (!empty($_SESSION['errors'])) {
	$errors = $_SESSION['errors'];
	unset($_SESSION['errors']);

	// Save the POST values.
	$repopulate_form = $_SESSION['form_values'];
	unset($_SESSION['form_values']);
} else {
	$errors = array();
	$repopulate_form = false;
}