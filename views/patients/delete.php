<div id="patients-delete">
	<div id="delete-dialog">
		<p>Da li ste sigurni da želite obrisati odabranog pacijenta?</p>
		<!-- Delete form -->
		<form action="/patients/destroy" method="post">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<input type="hidden" name="patient_id" value="<?= $patient['patient_id']; ?>" />
			<button type="submit">Da</button>
			<button type="button" onclick="window.location='/patients/';">Ne</button>
		</form>
	</div>
</div>