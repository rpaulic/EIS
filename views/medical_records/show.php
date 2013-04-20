<div id="medical-records-show">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<div id="show-buttons">
		<button type="button" onclick="window.location='/medical-records/';">Popis zapisa</button>
		<button type="button" onclick="window.location='/patients/';">Popis pacijenata</button>
		<button type="button" onclick="window.location='/patients/show/<?= $medical_record['patient_id']; ?>';">Pacijent</button>
		<button type="button" onclick="window.location='/medical-records/print/<?= $medical_record['medical_record_id']; ?>'">Ispiši</button>
	</div>
	<hr />
	<!-- Document header -->
	<div class="inline-table">
		<h4 class="page-subtitle">Zaglavlje dokumenta:</h4>
		<table class="show-details-table">
			<tr>
				<td class="details-name">Jedinstveni broj:</td>
				<td class="details-data-alternative"><?= padString($medical_record['document_uid'], 5); ?></td>
			</tr>
			<tr>
				<td class="details-name">Serija:</td>
				<td class="details-data-alternative"><?= $medical_record['document_series']; ?></td>
			</tr>
			<tr>
				<td class="details-name">Broj:</td>
				<td class="details-data-alternative"><?= padString($medical_record['document_number'], 3); ?></td>
			</tr>
			<tr>
				<td class="details-name">Nadnevak:</td>
				<td class="details-data-alternative"><?= formatDate($medical_record['document_date']); ?></td>
			</tr>
			<tr>
				<td class="details-name">Ispisan:</td>
				<td class="details-data-alternative"><?= $medical_record['is_printed']; ?></td>
			</tr>
			<tr>
				<td class="details-name">Zaključan:</td>
				<td class="details-data-alternative"><?= $medical_record['is_locked']; ?></td>
			</tr>
		</table>
	</div>
	<!-- Patient information -->
	<div class="inline-table">
		<h4 class="page-subtitle">Podaci o pacijentu:</h4>
		<table class="show-details-table">
			<tr>
				<td class="details-name">Oznaka:</td>
				<td class="details-data"><?= $medical_record['patient_code']; ?></td>
			</tr>
			<tr>
				<td class="details-name">Ime i prezime:</td>
				<td class="details-data"><?= h($medical_record['patient_full_name']); ?></td>
			</tr>
			<tr>
				<td class="details-name">Spol:</td>
				<td class="details-data"><?= $medical_record['patient_gender']; ?></td>
			</tr>
			<tr>
				<td class="details-name">Broj godina:</td>
				<td class="details-data"><?= $medical_record['patient_age']; ?></td>
			</tr>
		</table>
	</div>
	<!-- Document contents -->
	<?php if ($medical_record['anamnesis']): ?>
		<h4 class="page-subtitle">Anamneza:</h4>
		<pre class="show-description"><?= h($medical_record['anamnesis']); ?></pre>
	<?php endif; ?>
	<?php if ($medical_record['examination']): ?>
		<h4 class="page-subtitle">Pregled:</h4>
		<pre class="show-description"><?= h($medical_record['examination']); ?></pre>
	<?php endif; ?>
	<?php if ($medical_record['diagnosis']): ?>
		<h4 class="page-subtitle">Dijagnoza:</h4>
		<pre class="show-description"><?= h($medical_record['diagnosis']); ?></pre>
	<?php endif; ?>
	<?php if ($medical_record['therapy']): ?>
		<h4 class="page-subtitle">Terapija:</h4>
		<pre class="show-description"><?= h($medical_record['therapy']); ?></pre>
	<?php endif; ?>
	<?php if ($medical_record['recommendation']): ?>
		<h4 class="page-subtitle">Preporuka:</h4>
		<pre class="show-description"><?= h($medical_record['recommendation']); ?></pre>
	<?php endif; ?>
</div>