<div id="treatments-index">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Common actions -->
	<div id="search-bar">
		<form action="/treatments/" method="get" onsubmit="return validateForm(this);">
			<input type="text" name="filter" autofocus />
			<button type="submit">Traži</button>
		</form>
		<button type="button" onclick="window.location='/treatments/';">Prikaži sve</button>
	</div>
	<div id="button-new-entry">
		<button type="button" onclick="window.location='/treatments/new';">Novi unos</button>
	</div>
	<hr />
	<!-- List of entries -->
	<?php if(!$treatments): ?>
		<p id="no-entries">Ne postoji niti jedan unos...</p>
	<?php else: ?>
		<!-- Entries table -->
		<div class="scrollable-table">
			<table id="index-table">
				<tr>
					<th id="treatments-code-header" class="normal-header">Oznaka</th>
					<th id="treatments-title-header" class="normal-header">Naziv</th>
					<th id="treatments-type-header" class="normal-header">Vrsta</th>
					<th id="actions-header">Radnje</th>
				</tr>
				<?php foreach($treatments as $treatment): ?>
					<tr>
						<td id="treatments-code-data" class="normal-data"><?= $treatment['code']; ?></td>
						<td id="treatments-title-data" class="normal-data"><?= h($treatment['title']); ?></td>
						<td id="treatments-type-data" class="normal-data"><?= $treatment['type']; ?></td>
						<!-- Available actions -->
						<td>
							<button type="button" onclick="window.location='/treatments/show/<?= $treatment['treatment_id']; ?>'">Prikaži</button>
							<button type="button" onclick="window.location='/treatments/edit/<?= $treatment['treatment_id']; ?>'">Uredi</button>
							<button type="button" onclick="window.location='/treatments/delete/<?= $treatment['treatment_id']; ?>'">Obriši</button>
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