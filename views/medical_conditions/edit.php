<div id="medical-conditions-edit">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Edit form -->
	<div id="medical-conditions-form">
		<form class="form-default" action="/medical-conditions/update" method="post" onsubmit="return validateForm(this);">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<input type="hidden" name="medical_condition_id" value="<?= $medical_condition['medical_condition_id']; ?>" />
			<!-- Required fields -->
			<fieldset>
				<legend>Obavezna polja</legend>
				<label>
					Naziv:<span class="required-field">*</span><br />
					<input type="text" name="title" value="<?= rFormOnEdit($medical_condition, 'title'); ?>" autofocus /><br />
				</label>
				<label>
					Vrsta:<br />
					<select name="type">
						<option <?= rFormOnEdit($medical_condition, 'type', 'Bolest', true); ?> value="Bolest">Bolest</option>
						<option <?= rFormOnEdit($medical_condition, 'type', 'Poremećaj', true); ?> value="Poremećaj">Poremećaj</option>
						<option <?= rFormOnEdit($medical_condition, 'type', 'Oboljenje', true); ?> value="Oboljenje">Oboljenje</option>
						<option <?= rFormOnEdit($medical_condition, 'type', 'Ozljeda', true); ?> value="Ozljeda">Ozljeda</option>
						<option <?= rFormOnEdit($medical_condition, 'type', 'Ostalo', true); ?> value="Ostalo">Ostalo</option>
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
					<textarea name="description" spellcheck="false"><?= rFormOnEdit($medical_condition, 'description'); ?></textarea>
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