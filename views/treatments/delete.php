<div id="treatments-delete">
		<div id="delete-dialog">
		<p>Da li ste sigurni da želite obrisati odabranu terapiju?</p>
		<!-- Delete form -->
		<form action="/treatments/destroy" method="post">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<input type="hidden" name="treatment_id" value="<?= $treatment['treatment_id']; ?>" />
			<button type="submit">Da</button>
			<button type="button" onclick="window.location='/treatments/';">Ne</button>
		</form>
	</div>
</div>