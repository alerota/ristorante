<script>
function fase2()
{
	document.getElementById('verify').style.display = 'none';
	document.getElementById('details').style.display = 'block';
}
function fase1()
{
	document.getElementById('details').style.display = 'none';
	document.getElementById('verify').style.display = 'block';
}
</script>
<form method='POST' class='form' style='background-color: white; height: calc(100% - 52px); '>
	<div class="form-group">
		<br>
		<!-- Fase 1 -->
		<div class='verifica form-group' id='verify'>
			<fieldset>
				<div class="col-xs-12">
					<legend>Verifica disponibilità orario</legend>
				</div>
				<div class="col-xs-5">
					<a data-toggle="tooltip" title="Definisci il numero di partecipanti">
						<label>Numero</label>
					</a>
					<input type="number" name="num_persone" class="form-control" placeholder="Numero">
					<span class="help-block"></span>
				</div>
				<div class="col-xs-7">
					<label for="fase">Fase</label>
					<select class="form-control" id="fase" name="fase">
						<option value='a'>Mattino</option>
						<option value='b'>Pranzo</option>
						<option value='c'>Cena</option>
					</select>
				</div>
			</fieldset>
			<br>
			<div class="col-xs-12">
				<button onclick="fase2();" class="btn btn-primary" type="button">
						Verifica disponibilit&agrave
				</button>
			</div>
			<br>
		</div>
		
		<!-- Fase 2 -->
		<div class='choice form-group' id='choice'>
		
		</div>
		
		<!-- Fase 3 -->
		<div class='dettagli' id='details' style="display: none;">
			<fieldset>
				<div class="col-xs-12">
					<legend>Dettagli</legend>
				</div>
				
				<div class="col-xs-6">
					<label>Cognome</label>
					<input type="text" name="cognome" class="form-control" placeholder="Cognome">
					<span class="help-block"></span>
				</div>
				
				<div class="col-xs-6">
					<label>Telefono</label>
					<input type="text" name="tel" class="form-control" placeholder="Telefono">
					<span class="help-block"></span>
				</div>
				
				<div class="col-xs-12">
					<label>Note</label>
					<textarea class="form-control" name='note' id='note' style="height: 150px;" placeholder="Inserire qui eventuali note..."></textarea>
				</div>
			</fieldset>
			<br>
			
			<div class="col-xs-12">
				<button onclick="fase1();" class="btn btn-primary" type="button">
					Invia prenotazione
				</button>
			</div>
		</div>
	</div>
</form>