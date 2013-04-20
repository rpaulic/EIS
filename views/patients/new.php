<div id="patients-new">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Input form -->
	<div id="patients-form">
		<form class="form-default" action="/patients/create" method="post" onsubmit="return validateForm(this);">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<!-- Required fields -->
			<fieldset>
				<legend>Obavezna polja</legend>
				<label>
					Ime:<span class="required-field">*</span><br />
					<input type="text" name="first_name" value="<?= rFormOnError('first_name'); ?>" autofocus /><br />
				</label>
				<label>
					Prezime:<span class="required-field">*</span><br />
					<input type="text" name="last_name" value="<?= rFormOnError('last_name'); ?>" /><br />
				</label>
				<label>
					Spol:<br />
					<select name="gender">
						<option <?= rFormOnError('gender', 'Muški', true); ?> value="Muški">Muški</option>
						<option <?= rFormOnError('gender', 'Ženski', true); ?> value="Ženski">Ženski</option>
					</select>
					<br />
				</label>
				<label>
					Datum rođenja:<span class="required-field">*</span><br />
					<input type="text" name="birthdate" value="<?= rFormOnError('birthdate'); ?>" />
				</label>
			</fieldset>
			<br />
			<!-- Optional fields -->
			<fieldset>
				<legend>Dodatna polja</legend>
				<label>
					OIB:<br />
					<input type="text" name="oib" value="<?= rFormOnError('oib'); ?>" /><br />
				</label>
				<label>
					Adresa:<br />
					<input type="text" name="address" value="<?= rFormOnError('address'); ?>" /><br />
				</label>
				<label>
					Poštanski broj:<br />
					<input type="text" name="postal_code" value="<?= rFormOnError('postal_code'); ?>" /><br />
				</label>
				<label>
					Mjesto:<br />
					<input type="text" name="location" value="<?= rFormOnError('location'); ?>" /><br />
				</label>
				<label>
					Telefonski broj:<br />
					<input type="text" name="phone_number" value="<?= rFormOnError('phone_number'); ?>" /><br />
				</label>
				<label>
					Email:<br />
					<input type="text" name="email" value="<?= rFormOnError('email'); ?>" />
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