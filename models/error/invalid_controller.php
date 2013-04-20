<?php

// Error handling when the requested controller does not exist.
$_SESSION['flash'] = 'Tražena stranica ne postoji!';

header('Location: /');
exit;