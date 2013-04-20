<!-- Default template -->
<!DOCTYPE html>
<html lang="hr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="/stylesheets/default.css" />
		<title><?= $page_title; ?> | e-Zdravstvo</title>
	</head>
	<body>
		<div id="container">
			<!-- Header -->
			<div id="header">
				<?php if ($logged_in): ?>
					<h2><a href="/">Izbornik</a></h2>
				<?php else: ?>
					<h2>e-Zdravstvo</h2>
				<?php endif; ?>
			</div>
			<!-- Flash message -->
			<?php if ($flash): ?>
				<div id="flash-message">
					<p><?= $flash; ?></p>
				</div>
			<?php endif; ?>
			<!-- Error messages -->
			<?php if ($errors): ?>
				<div id="error-messages">
					<p>Pogreške:</p>
					<ol>
						<?php foreach ($errors as $error): ?>
							<li><?= $error; ?></li>
						<?php endforeach; ?>
					</ol>
				</div>
			<?php endif; ?>
			<!-- Main content -->
			<div id="main">
				<?= $view_contents; ?>
			</div>
			<!-- Footer -->
			<div id="footer">
				<?php if ($logged_in): ?>
					<p><a href="/about/">e-Zdravstvo, 2011.</a></p>
				<?php else: ?>
					<p>e-Zdravstvo, 2011.</p>
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>