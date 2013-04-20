<div id="medical-records-delete">
	<div id="delete-dialog">
		<p>Da li ste sigurni da želite obrisati odabrani zapis?</p>
		<!-- Delete form -->
		<form action="/medical-records/destroy" method="post">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<input type="hidden" name="medical_record_id" value="<?= $medical_record['medical_record_id']; ?>" />
			<button type="submit">Da</button>
			<button type="button" onclick="window.location='/medical-records/';">Ne</button>
		</form>
	</div>
</div>