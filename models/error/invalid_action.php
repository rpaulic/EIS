<?php

// Error handling when the requested action does not exist.
$_SESSION['flash'] = 'Nepostojeća radnja!';

if ($controller == 'login')
	$header_location = '/';
else
	$header_location = '/' . $controller . '/';

header('Location: ' . $header_location);
exit;