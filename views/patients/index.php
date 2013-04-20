<div id="patients-index">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Common actions -->
	<div id="search-bar">
		<form action="/patients/" method="get" onsubmit="return validateForm(this);">
			<input type="text" name="filter" autofocus />
			<button type="submit">Traži</button>
		</form>
		<button type="button" onclick="window.location='/patients/';">Prikaži sve</button>
	</div>
	<div id="button-new-entry">
		<button type="button" onclick="window.location='/patients/new';">Novi unos</button>
	</div>
	<hr />
	<!-- List of entries -->
	<?php if(!$patients): ?>
		<p id="no-entries">Ne postoji niti jedan unos...</p>
	<?php else: ?>
		<!-- Entries table -->
		<div class="scrollable-table">
			<table id="index-table">
				<tr>
					<th id="patients-code-header" class="normal-header">Oznaka</th>
					<th id="patients-first-name-header" class="normal-header">Ime</th>
					<th id="patients-last-name-header" class="normal-header">Prezime</th>
					<th id="patients-gender-header" class="normal-header">Spol</th>
					<th id="patients-birthdate-header" class="normal-header">Rođen</th>
					<th id="actions-header">Radnje</th>
				</tr>
				<?php foreach($patients as $patient): ?>
					<tr>
						<td id="patients-code-data" class="normal-data"><?= $patient['code']; ?></td>
						<td id="patients-first-name-data" class="normal-data"><?= h($patient['first_name']); ?></td>
						<td id="patients-last-name-data" class="normal-data"><?= h($patient['last_name']); ?></td>
						<td id="patients-gender-data" class="normal-data"><?= $patient['gender']; ?></td>
						<td id="patients-birthdate-data" class="normal-data"><?= formatDate($patient['birthdate']); ?></td>
						<!-- Available actions -->
						<td>
							<button type="button" onclick="window.location='/patients/show/<?= $patient['patient_id']; ?>'">Prikaži</button>
							<button type="button" onclick="window.location='/patients/edit/<?= $patient['patient_id']; ?>'">Uredi</button>
							<button type="button" onclick="window.location='/patients/delete/<?= $patient['patient_id']; ?>'">Obriši</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	<?php endif; ?>
</div>

<script>

// Prevents form submission unless all required fields are filled in.
function validateForm(form)
{
	var is_valid = true;

	if (form.filter.value.length === 0) {
		is_valid = false;
	}

	return is_valid;
}

</script>