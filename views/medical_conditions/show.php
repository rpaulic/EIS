<div id="medical-conditions-show">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<div id="show-buttons">
		<button type="button" onclick="window.location='/medical-conditions/';">Natrag</button>
	</div>
	<hr />
	<!-- Basic information -->
	<h4 class="page-subtitle">Osnovni podaci:</h4>
	<table class="show-details-table">
		<tr>
			<td class="details-name">Oznaka:</td>
			<td class="details-data"><?= $medical_condition['code']; ?></td>
		</tr>
		<tr>
			<td class="details-name">Naziv:</td>
			<td class="details-data"><?= h($medical_condition['title']); ?></td>
		</tr>
		<tr>
			<td class="details-name">Vrsta:</td>
			<td class="details-data"><?= $medical_condition['type']; ?></td>
		</tr>
	</table>
	<!-- Description -->
	<h4 class="page-subtitle">Opis:</h4>
	<pre class="show-description"><?= h($medical_condition['description']); ?></pre>
</div>