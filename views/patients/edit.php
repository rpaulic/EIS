<div id="patients-edit">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Edit form -->
	<div id="patients-form">
		<form class="form-default" action="/patients/update" method="post" onsubmit="return validateForm(this);">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<input type="hidden" name="patient_id" value="<?= $patient['patient_id']; ?>" />
			<!-- Required fields -->
			<fieldset>
				<legend>Obavezna polja</legend>
				<label>
					Ime:<span class="required-field">*</span><br />
					<input type="text" name="first_name" value="<?= rFormOnEdit($patient, 'first_name'); ?>" autofocus /><br />
				</label>
				<label>
					Prezime:<span class="required-field">*</span><br />
					<input type="text" name="last_name" value="<?= rFormOnEdit($patient, 'last_name'); ?>" /><br />
				</label>
				<label>
					Spol:<br />
					<select name="gender">
						<option <?= rFormOnEdit($patient, 'gender', 'Muški', true); ?> value="Muški">Muški</option>
						<option <?= rFormOnEdit($patient, 'gender', 'Ženski', true); ?> value="Ženski">Ženski</option>
					</select>
					<br />
				</label>
				<label>
					Datum rođenja:<span class="required-field">*</span><br />
					<input type="text" name="birthdate" value="<?= rFormOnEdit($patient, 'birthdate'); ?>" />
				</label>
			</fieldset>
			<br />
			<!-- Optional fields -->
			<fieldset>
				<legend>Dodatna polja</legend>
				<label>
					OIB:<br />
					<input type="text" name="oib" value="<?= rFormOnEdit($patient, 'oib'); ?>" /><br />
				</label>
				<label>
					Adresa:<br />
					<input type="text" name="address" value="<?= rFormOnEdit($patient, 'address'); ?>" /><br />
				</label>
				<label>
					Poštanski broj:<br />
					<input type="text" name="postal_code" value="<?= rFormOnEdit($patient, 'postal_code'); ?>" /><br />
				</label>
				<label>
					Mjesto:<br />
					<input type="text" name="location" value="<?= rFormOnEdit($patient, 'location'); ?>" /><br />
				</label>
				<label>
					Telefonski broj:<br />
					<input type="text" name="phone_number" value="<?= rFormOnEdit($patient, 'phone_number'); ?>" /><br />
				</label>
				<label>
					Email:<br />
					<input type="text" name="email" value="<?= rFormOnEdit($patient, 'email'); ?>" />
				</label>
			</fieldset>
			<button class="button-default" type="submit">Spremi</button>
			<button class="button-default" type="button" onclick="window.location='/patients/';">Natrag</button>
		</form>
	</div>
</div>

<script>

// Prevents form submission unless all required fields are filled in.
function validateForm(form)
{
	var is_valid = true;

	if (form.first_name.value.length === 0) {
		is_valid = false;
	} else if (form.last_name.value.length === 0) {
		is_valid = false;
	} else if (form.birthdate.value.length === 0) {
		is_valid = false;
	}

	return is_valid;
}

</script>