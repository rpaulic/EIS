<div id="login-index">
	<!-- Login form -->
	<form class="form-default" action="/login/sign-in" method="post" onsubmit="return validateForm(this);">
		<fieldset>
			<label>
				Korisnik:<span class="required-field">*</span><br />
				<input type="text" name="user" value="<?= rFormOnError('user'); ?>" autofocus /><br />
			</label>
			<label>
				Zaporka:<span class="required-field">*</span><br />
				<input type="password" name="password" />
			</label>
		</fieldset>
		<button class="button-default" type="submit">Prijavi me</button>
	</form>
</div>

<script>

// Prevents form submission unless all required fields are filled in.
function validateForm(form)
{
	var is_valid = true;

	if (form.user.value.length === 0) {
		is_valid = false;
	} else if (form.password.value.length === 0) {
		is_valid = false;
	}

	return is_valid;
}

</script>