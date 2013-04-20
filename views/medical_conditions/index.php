<div id="medical-conditions-index">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Common actions -->
	<div id="search-bar">
		<form action="/medical-conditions/" method="get" onsubmit="return validateForm(this);">
			<input type="text" name="filter" autofocus />
			<button type="submit">Traži</button>
		</form>
		<button type="button" onclick="window.location='/medical-conditions/';">Prikaži sve</button>
	</div>
	<div id="button-new-entry">
		<button type="button" onclick="window.location='/medical-conditions/new';">Novi unos</button>
	</div>
	<hr />
	<!-- List of entries -->
	<?php if(!$medical_conditions): ?>
		<p id="no-entries">Ne postoji niti jedan unos...</p>
	<?php else: ?>
		<!-- Entries table -->
		<div class="scrollable-table">
			<table id="index-table">
				<tr>
					<th id="medical-conditions-code-header" class="normal-header">Oznaka</th>
					<th id="medical-conditions-title-header" class="normal-header">Naziv</th>
					<th id="medical-conditions-type-header" class="normal-header">Vrsta</th>
					<th id="actions-header">Radnje</th>
				</tr>
				<?php foreach($medical_conditions as $medical_condition): ?>
					<tr>
						<td id="medical-conditions-code-data" class="normal-data"><?= $medical_condition['code']; ?></td>
						<td id="medical-conditions-title-data" class="normal-data"><?= h($medical_condition['title']); ?></td>
						<td id="medical-conditions-type-data" class="normal-data"><?= $medical_condition['type']; ?></td>
						<!-- Available actions -->
						<td>
							<button type="button" onclick="window.location='/medical-conditions/show/<?= $medical_condition['medical_condition_id']; ?>'">Prikaži</button>
							<button type="button" onclick="window.location='/medical-conditions/edit/<?= $medical_condition['medical_condition_id']; ?>'">Uredi</button>
							<button type="button" onclick="window.location='/medical-conditions/delete/<?= $medical_condition['medical_condition_id']; ?>'">Obriši</button>
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