<?php

// Redirect to the default page if the user is logged in.
if ($logged_in) {
	header('Location: /');
	exit;
}