<div id="medical-records-print">
	<div id="print-dialog">
		<p>
			Da li ste sigurni da želite ispisati i zaključati odabrani zapis?<br />
			Zaključani zapis nije više moguće uređivati.
		</p>
		<!-- Print form -->
		<form action="/medical-records/output" method="post">
			<input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>" />
			<input type="hidden" name="medical_record_id" value="<?= $medical_record['medical_record_id']; ?>" />
			<button type="submit">Da</button>
			<button type="button" onclick="window.location='/medical-records/show/<?= $medical_record['medical_record_id']; ?>';">Natrag</button>
		</form>
	</div>
</div>