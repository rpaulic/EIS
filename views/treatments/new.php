<div id="treatments-new">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Input form -->
	<div id="treatments-form">
		<form class="form-default" action="/treatments/create" method="post" onsubmit="return validateForm(this);">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<!-- Required fields -->
			<fieldset>
				<legend>Obavezna polja</legend>
				<label>
					Naziv:<span class="required-field">*</span><br />
					<input type="text" name="title" value="<?= rFormOnError('title'); ?>" autofocus /><br />
				</label>
				<label>
					Vrsta:<br />
					<select name="type">
						<option <?= rFormOnError('type', 'Lijek', true); ?> value="Lijek">Lijek</option>
						<option <?= rFormOnError('type', 'Ljudska interakcija', true); ?> value="Ljudska interakcija">Ljudska interakcija</option>
						<option <?= rFormOnError('type', 'Energija', true); ?> value="Energija">Energija</option>
						<option <?= rFormOnError('type', 'Meditacija', true); ?> value="Meditacija">Meditacija</option>
						<option <?= rFormOnError('type', 'Ostalo', true); ?> value="Ostalo">Ostalo</option>
					</select>
					<br />
				</label>
			</fieldset>
			<br />
			<!-- Optional fields -->
			<fieldset>
				<legend>Dodatna polja</legend>
				<label>
					Opis:<br />
					<textarea name="description" spellcheck="false"><?= rFormOnError('description'); ?></textarea>
				</label>
			</fieldset>
			<button class="button-default" type="submit">Spremi</button>
			<button class="button-default" type="button" onclick="window.location='/treatments/';">Natrag</button>
		</form>
	</div>
</div>

<script>

// Prevents form submission unless all required fields are filled in.
function validateForm(form)
{
	var is_valid = true;

	if (form.title.value.length === 0) {
		is_valid = false;
	}

	return is_valid;
}

</script>