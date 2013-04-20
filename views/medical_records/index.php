<div id="medical-records-index">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Common actions -->
	<div id="search-bar">
		<form action="/medical-records/" method="get" onsubmit="return validateForm(this);">
			<input type="text" name="filter" autofocus />
			<button type="submit">Traži</button>
		</form>
		<button type="button" onclick="window.location='/medical-records/';">Prikaži sve</button>
	</div>
	<div id="button-new-entry">
		<button type="button" onclick="window.location='/medical-records/new';">Novi unos</button>
	</div>
	<hr />
	<!-- List of entries -->
	<?php if(!$medical_records): ?>
		<p id="no-entries">Ne postoji niti jedan unos...</p>
	<?php else: ?>
		<!-- Entries table -->
		<div class="scrollable-table">
			<table id="index-table">
				<tr>
					<th id="medical-records-document-uid-header" class="normal-header">Jed. broj</th>
					<th id="medical-records-document-series-header" class="normal-header">Serija</th>
					<th id="medical-records-document-number-header" class="normal-header">Broj</th>
					<th id="medical-records-document-date-header" class="normal-header">Nadnevak</th>
					<th id="medical-records-patient-code-header" class="normal-header">Oznaka</th>
					<th id="medical-records-patient-full-name-header" class="normal-header">Ime i prezime</th>
					<th id="medical-records-is-printed-header" class="normal-header">Ispisan</th>
					<th id="medical-records-is-locked-header" class="normal-header">Zaključan</th>
					<th id="actions-header">Radnje</th>
				</tr>
				<?php foreach($medical_records as $medical_record): ?>
					<tr>
						<td id="medical-records-document-uid-data" class="normal-data"><?= padString($medical_record['document_uid'], 5); ?></td>
						<td id="medical-records-document-series-data" class="normal-data"><?= $medical_record['document_series']; ?></td>
						<td id="medical-records-document-number-data" class="normal-data"><?= padString($medical_record['document_number'], 3); ?></td>
						<td id="medical-records-document-date-data" class="normal-data"><?= formatDate($medical_record['document_date']); ?></td>
						<td id="medical-records-patient-code-data" class="normal-data"><?= $medical_record['patient_code']; ?></td>
						<td id="medical-records-patient-full-name-data" class="normal-data"><a href="/patients/show/<?= $medical_record['patient_id']; ?>"><?= h($medical_record['patient_full_name']); ?></a></td>
						<td id="medical-records-is-printed-data" class="normal-data"><?= $medical_record['is_printed']; ?></td>
						<td id="medical-records-is-locked-data" class="normal-data"><?= $medical_record['is_locked']; ?></td>
						<!-- Available actions -->
						<td>
							<button type="button" onclick="window.location='/medical-records/show/<?= $medical_record['medical_record_id']; ?>'">Prikaži</button>
							<button type="button" onclick="window.location='/medical-records/edit/<?= $medical_record['medical_record_id']; ?>'">Uredi</button>
							<button type="button" onclick="window.location='/medical-records/delete/<?= $medical_record['medical_record_id']; ?>'">Obriši</button>
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