<script>
function fase3(a, b)
{
	document.getElementById("orario").value = a;
	document.getElementById("sala").value = b;
	// alert("Hai scelto l'orario: " + a + "\nHai scelto la sala: " + b);
	document.getElementById('verify').style.display = 'none';
	document.getElementById('choice').style.display = 'none';
	document.getElementById('details').style.display = 'block';
}
function fase2()
{
	ricercaSaleDisponibili();
	document.getElementById('verify').style.display = 'none';
	document.getElementById('choice').style.display = 'block';
	document.getElementById('details').style.display = 'none';
}
function fase1()
{
	document.getElementById('details').style.display = 'none';
	document.getElementById('choice').style.display = 'none';
	document.getElementById('verify').style.display = 'block';
}

var req;
function loadDoc(url, postvalue) {
   req = getAjaxControl();
   if(req) {
      req.open("POST", url, false); // sincrono
      req.setRequestHeader("Content-Type", "text/xml")
      req.send(postvalue);
   }
}

function getAjaxControl() {
   req = false;
   // branch for native XMLHttpRequest object
   if(window.XMLHttpRequest && !(window.ActiveXObject)) {
      try {
         req = new XMLHttpRequest();
      } catch(e) {
         req = false;
      }
   // branch for IE/Windows ActiveX version
   } else if(window.ActiveXObject) {
      try {
         req = new ActiveXObject("Msxml2.XMLHTTP");
      } catch(e) {
         try {
            req = new ActiveXObject("Microsoft.XMLHTTP");
         } catch(e) {
            req = false;
         }
      }
   }
   return req;
}
function ricercaFasiDisponibili()
{
	loadDoc("codici/ricercaFasi.php?date=" + document.getElementById("giornata").value,"");
    document.getElementById("selezioneFasi").innerHTML=req.responseText;
}
function ricercaSaleDisponibili()
{
	var numeroPersone = document.getElementById("numero").value;
	var faseScelta = document.getElementById("fase").value;
	
	if(numeroPersone > 0)
	{
		loadDoc("codici/ricercaFasciaOraria.php?date=<?php echo $_GET["date"]; ?>&numeroPartecipanti=" + numeroPersone + "&fase=" + faseScelta,"");
		document.getElementById("selezioneSale").innerHTML=req.responseText;
	}
	else
		alert("Inserire il numero di partecipanti!");
}
</script>
<style>
.sceltaSala { margin: 0px 0px 10px 10px; }
</style>
<form method='POST' class='form' style='background-color: white; height: calc(100% - 52px); '>
	<div class="form-group">
		<div class="text-center">
			<ul class="pagination">
				<li style="cursor: pointer;" class="active"><a onclick="fase1();">1</a></li>
				<li style="cursor: pointer;"><a onclick="fase2();">2</a></li>
				<li style="cursor: pointer;"><a onclick="fase3();">3</a></li>
			</ul>
		</div>
		<!-- Fase 1 -->
		<div class='verifica form-group' id='verify'>
			<fieldset>
				<div class="col-xs-12">
					<legend>Verifica la disponibilit&agrave</legend>
				</div>
				<div class="col-xs-5">
					<a data-toggle="tooltip" title="Definisci il numero di partecipanti">
						<label>Numero</label>
					</a>
					<input type="number" name="num_persone" class="form-control" id="numero" placeholder="Numero">
					<span class="help-block"></span>
				</div>
				<div class="col-xs-7">
					<label for="fase">Fase</label>
					<div id="selezioneFasi" onload="ricercaFasiDisponibili();"></div>
				</div>
				<input type="hidden" name="giornata" id="giornata" value="<?php echo $_GET["date"]; ?>" />
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
		<div class='choice' id='choice' style="display: none;">
			<fieldset>
				<div class="col-xs-12">
					<legend>Scegli un orario e una sala</legend>
				</div>
				<div class="col-xs-12" id="selezioneSale"></div>
				<input type="hidden" name="orario" value="" id="orario" />
				<input type="hidden" name="sala" value="" id="sala" />
			</fieldset>
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
<script>
ricercaFasiDisponibili();
</script>