<div id="patients-show">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<div id="show-buttons">
		<button type="button" onclick="window.location='/patients/';">Popis pacijenata</button>
		<button type="button" onclick="window.location='/medical-records/';">Popis zapisa</button>
	</div>
	<hr />
	<!-- Basic information -->
	<h4 class="page-subtitle">Osnovni podaci:</h4>
	<table class="show-details-table">
		<tr>
			<td class="details-name">Oznaka:</td>
			<td class="details-data"><?= $patient['code']; ?></td>
		</tr>
		<tr>
			<td class="details-name">Ime:</td>
			<td class="details-data"><?= h($patient['first_name']); ?></td>
		</tr>
		<tr>
			<td class="details-name">Prezime:</td>
			<td class="details-data"><?= h($patient['last_name']); ?></td>
		</tr>
		<tr>
			<td class="details-name">Spol:</td>
			<td class="details-data"><?= $patient['gender']; ?></td>
		</tr>
		<tr>
			<td class="details-name">Datum rođenja:</td>
			<td class="details-data"><?= formatDate($patient['birthdate']); ?></td>
		</tr>
		<tr>
			<td class="details-name">OIB:</td>
			<td class="details-data"><?= h($patient['oib']); ?></td>
		</tr>
		<tr>
			<td class="details-name">Adresa:</td>
			<td class="details-data"><?= h($patient['address']); ?></td>
		</tr>
		<tr>
			<td class="details-name">Poštanski broj:</td>
			<td class="details-data"><?= $patient['postal_code']; ?></td>
		</tr>
		<tr>
			<td class="details-name">Mjesto:</td>
			<td class="details-data"><?= h($patient['location']); ?></td>
		</tr>
		<tr>
			<td class="details-name">Telefonski broj:</td>
			<td class="details-data"><?= h($patient['phone_number']); ?></td>
		</tr>
		<tr>
			<td class="details-name">Email:</td>
			<td class="details-data"><?= h($patient['email']); ?></td>
		</tr>
	</table>
	<!-- Medical records -->
	<h4 class="page-subtitle">Zdravstveni karton:</h4>
	<?php if(!$medical_records): ?>
		<p id="no-entries-in-patients-show">Ne postoji niti jedan unos...</p>
	<?php else: ?>
		<!-- Entries table -->
		<div id="index-table-in-patients-show">
			<table id="index-table">
				<tr>
					<th id="medical-records-document-uid-header" class="normal-header">Jed. broj</th>
					<th id="medical-records-document-series-header" class="normal-header">Serija</th>
					<th id="medical-records-document-number-header" class="normal-header">Broj</th>
					<th id="medical-records-document-date-header" class="normal-header">Nadnevak</th>
					<th id="medical-records-is-printed-header" class="normal-header">Ispisan</th>
					<th id="medical-records-is-locked-header" class="normal-header">Zaključan</th>
					<th id="action-header">Radnja</th>
				</tr>
				<?php foreach($medical_records as $m): ?>
					<tr>
						<td id="medical-records-document-uid-data" class="normal-data"><?= padString($m['document_uid'], 5); ?></td>
						<td id="medical-records-document-series-data" class="normal-data"><?= $m['document_series']; ?></td>
						<td id="medical-records-document-number-data" class="normal-data"><?= padString($m['document_number'], 3); ?></td>
						<td id="medical-records-document-date-data" class="normal-data"><?= formatDate($m['document_date']); ?></td>
						<td id="medical-records-is-printed-data" class="normal-data"><?= $m['is_printed']; ?></td>
						<td id="medical-records-is-locked-data" class="normal-data"><?= $m['is_locked']; ?></td>
						<!-- Available actions -->
						<td><button type="button" onclick="window.location='/medical-records/show/<?= $m['medical_record_id']; ?>'">Prikaži</button></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	<?php endif; ?>
</div>