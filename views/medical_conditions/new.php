<div id="medical-conditions-new">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Input form -->
	<div id="medical-conditions-form">
		<form class="form-default" action="/medical-conditions/create" method="post" onsubmit="return validateForm(this);">
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
						<option <?= rFormOnError('type', 'Bolest', true); ?> value="Bolest">Bolest</option>
						<option <?= rFormOnError('type', 'Poremećaj', true); ?> value="Poremećaj">Poremećaj</option>
						<option <?= rFormOnError('type', 'Oboljenje', true); ?> value="Oboljenje">Oboljenje</option>
						<option <?= rFormOnError('type', 'Ozljeda', true); ?> value="Ozljeda">Ozljeda</option>
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
			<button class="button-default" type="button" onclick="window.location='/medical-conditions/';">Natrag</button>
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