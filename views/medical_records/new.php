<div id="medical-records-new">
	<!-- Page title -->
	<div id="page-title">
		<p><?= $page_title; ?></p>
	</div>
	<!-- Input form -->
	<div id="medical-records-form">
		<form class="form-default" action="/medical-records/create" method="post" onsubmit="return validateForm(this);">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<!-- Required fields -->
			<fieldset>
				<legend>Zaglavlje dokumenta</legend>
				<label>
					Pacijent:<br />
					<select name="patient_id" autofocus>
						<?php foreach ($patients as $p): ?>
							<?php $p_id = $p['patient_id']; ?>
							<?php $p_information = h($p['full_name']) . ' [' . $p['code'] . ']'; ?>
							<option <?= rFormOnError('patient_id', $p_id, true); ?> value="<?= $p_id; ?>">
								<?= $p_information; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</label>
			</fieldset>
			<br />
			<!-- Optional fields -->
			<fieldset>
				<legend>Sadržaj dokumenta</legend>
				<label>
					Anamneza:<br />
					<textarea name="anamnesis" spellcheck="false"><?= rFormOnError('anamnesis'); ?></textarea><br />
				</label>
				<label>
					Pregled:<br />
					<textarea name="examination" spellcheck="false"><?= rFormOnError('examination'); ?></textarea><br />
				</label>
				<label>
					Dijagnoza:<br />
					<textarea name="diagnosis" spellcheck="false"><?= rFormOnError('diagnosis'); ?></textarea><br />
				</label>
				<label>
					Terapija:<br />
					<textarea name="therapy" spellcheck="false"><?= rFormOnError('therapy'); ?></textarea><br />
				</label>
				<label>
					Preporuka:<br />
					<textarea name="recommendation" spellcheck="false"><?= rFormOnError('recommendation'); ?></textarea>
				</label>
			</fieldset>
			<button class="button-default" type="submit">Spremi</button>
			<button class="button-default" type="button" onclick="window.location='/medical-records/';">Natrag</button>
		</form>
	</div>
</div>

<script>

// Prevents document submission when there is no content.
function validateForm(form)
{
	var is_valid = true;

	if (form.anamnesis.value.length      === 0 &&
		form.examination.value.length    === 0 &&
		form.diagnosis.value.length      === 0 &&
		form.therapy.value.length        === 0 &&
		form.recommendation.value.length === 0)
	{
		is_valid = false;
	}

	return is_valid;
}

</script>