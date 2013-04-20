<div id="medical-conditions-delete">
	<div id="delete-dialog">
		<p>Da li ste sigurni da želite obrisati odabrani zdravstveni problem?</p>
		<!-- Delete form -->
		<form action="/medical-conditions/destroy" method="post">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<input type="hidden" name="medical_condition_id" value="<?= $medical_condition['medical_condition_id']; ?>" />
			<button type="submit">Da</button>
			<button type="button" onclick="window.location='/medical-conditions/';">Ne</button>
		</form>
	</div>
</div>