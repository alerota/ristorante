<script>
	function isMobile() {
		return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf("IEMobile") !== -1);
	}
	
	function isValidNumber(t)
	{
		while(t.indexOf(" ") != -1)
			t = t.str_replace(" ", "");
		
		return t != "";
	}
	
	function controllo() {
		var a = document.getElementById("cognome").value;
		var b = document.getElementById("tel").value;
		<?php
			if(isset($_COOKIE["login"]))
				echo "if (a != '')";
			else
				echo "if (a != '' && isValidNumber(b))";
		?>
			document.getElementById('formPrenotazione').submit();
		else
			alert("Compila i campi del nome e del numero di telefono!");
	}

	function fase3(a, b) {
		document.getElementById("orario").value = a;
		document.getElementById("sala").value = b;
		if (document.getElementById("l1").classList.contains("active"))
			document.getElementById("l1").classList.remove("active");
		if (document.getElementById("l2").classList.contains("active"))
			document.getElementById("l2").classList.remove("active");
		if (!document.getElementById("l3").classList.contains("active"))
			document.getElementById("l3").classList.add("active");
		document.getElementById('verify').style.display = 'none';
		document.getElementById('choice').style.display = 'none';
		document.getElementById('details').style.display = 'block';
		if (isMobile())
			document.getElementById('formPrenotazione').style.height = (140 + document.getElementById('details').offsetHeight) + "px";
	}

	function ricercaSicura() {
		ricercaSaleAdmin();
		if (document.getElementById("l1").classList.contains("active"))
			document.getElementById("l1").classList.remove("active");
		if (!document.getElementById("l2").classList.contains("active"))
			document.getElementById("l2").classList.add("active");
		if (document.getElementById("l3").classList.contains("active"))
			document.getElementById("l3").classList.remove("active");
		document.getElementById('verify').style.display = 'none';
		document.getElementById('choice').style.display = 'block';
		document.getElementById('details').style.display = 'none';
		if (isMobile())
			document.getElementById('formPrenotazione').style.height = (100 + document.getElementById('choice').offsetHeight) + "px";
	}

	function fase2() {
		ricercaSaleDisponibili();
		document.getElementById("fase123").value = document.getElementById("fase").value;

		if (document.getElementById("l1").classList.contains("active"))
			document.getElementById("l1").classList.remove("active");
		if (!document.getElementById("l2").classList.contains("active"))
			document.getElementById("l2").classList.add("active");
		if (document.getElementById("l3").classList.contains("active"))
			document.getElementById("l3").classList.remove("active");
		document.getElementById('verify').style.display = 'none';
		document.getElementById('choice').style.display = 'block';
		document.getElementById('details').style.display = 'none';
		if (isMobile())
			document.getElementById('formPrenotazione').style.height = (100 + document.getElementById('choice').offsetHeight) + "px";
	}

	function fase1() {
		if (!document.getElementById("l1").classList.contains("active"))
			document.getElementById("l1").classList.add("active");
		if (document.getElementById("l2").classList.contains("active"))
			document.getElementById("l2").classList.remove("active");
		if (document.getElementById("l3").classList.contains("active"))
			document.getElementById("l3").classList.remove("active");
		document.getElementById('details').style.display = 'none';
		document.getElementById('choice').style.display = 'none';
		document.getElementById('verify').style.display = 'block';
	}

	var req;

	function loadDoc(url, postvalue) {
		req = getAjaxControl();
		if (req) {
			req.open("POST", url, false); // sincrono
			req.setRequestHeader("Content-Type", "text/xml")
			req.send(postvalue);
		}
	}

	function getAjaxControl() {
		req = false;
		// branch for native XMLHttpRequest object
		if (window.XMLHttpRequest && !(window.ActiveXObject)) {
			try {
				req = new XMLHttpRequest();
			} catch (e) {
				req = false;
			}
			// branch for IE/Windows ActiveX version
		} else if (window.ActiveXObject) {
			try {
				req = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					req = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					req = false;
				}
			}
		}
		return req;
	}

	function ricercaFasiDisponibili() {
		loadDoc("http://prenotazioni.ristorante-almolo13.com/codici/ricerca/ricercaFasi.php?date=" + document.getElementById("giornata").value, "");
		document.getElementById("selezioneFasi").innerHTML = req.responseText;
	}

	function ricercaSaleDisponibili() {
		var numeroPersone = document.getElementById("numero").value;
		var faseScelta = document.getElementById("fase").value;

		if (numeroPersone > 0) {
			loadDoc("http://prenotazioni.ristorante-almolo13.com/codici/ricerca/ricercaFasciaOraria.php?date=<?php echo $_GET["date"]; ?>&numeroPartecipanti=" + numeroPersone + "&fase=" + faseScelta, "");
			document.getElementById("selezioneSale").innerHTML = req.responseText;
		}
		else
			alert("Inserire il numero di partecipanti!");
	}

	function ricercaSaleAdmin() {
		var numeroPersone = document.getElementById("numero").value;
		var faseScelta = document.getElementById("fase").value;

		if (numeroPersone > 0) {
			loadDoc("http://prenotazioni.ristorante-almolo13.com/codici/ricerca/ricercaFasciaOrariaAdmin.php?date=<?php echo $_GET["date"]; ?>&fase=" + faseScelta, "");
			document.getElementById("selezioneSale").innerHTML = req.responseText;
		}
		else
			alert("Inserire il numero di partecipanti!");
	}
</script>
<style>
	.sceltaSala {
		margin: 0px 0px 10px 10px;
	}

	.dot {
		height: 16px !important;
		width: 16px !important;
		padding: 0px !important;
		background-color: #bbb;
		border-radius: 50% !important;
		display: inline-block;
		margin: 10px;
		transition-duration: 0.4s;
	}
</style>
<form method='POST' id="formPrenotazione" class='form' action="codici/insert/insertPrenotazione.php" style='background-color: white; height: 100%; '>
	<div class="form-group">
		<div class="text-center">
			<ul class="pagination">
				<li class="std" id="l1"><a class="dot"></a></li>
				<li class="std" id="l2"><a class="dot"></a></li>
				<li class="std" id="l3"><a class="dot"></a></li>
			</ul>
		</div>
		<!-- Fase 1 -->
		<div class='verifica form-group' id='verify'>
			<fieldset>
				<div class="col-xs-12">
					<legend>Verifica la disponibilit&agrave;</legend>
				</div>
				<div class="col-xs-5">
					<a data-toggle="tooltip" title="Definisci il numero di partecipanti">
						<label>Numero persone</label>
					</a>
					<input type="number" min="1" onfocus="document.getElementById('verifyButton').disabled = false;"
						   name="num_persone" class="form-control" id="numero" placeholder="Numero">
					<span class="help-block"></span>
				</div>
				<div class="col-xs-7">
					<label for="fase">Fase</label>
					<div id="selezioneFasi" onload="ricercaFasiDisponibili();"></div>
				</div>
				<input type="hidden" name="fase123" id="fase123"/>
				<input type="hidden" name="giornata" id="giornata" value="<?php echo $_GET["date"]; ?>"/>
			</fieldset>
			<br>
			<div class="col-xs-12">
				<button onclick="fase2();" class="btn btn-primary" type="button" id="verifyButton" disabled>
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
				<input type="hidden" name="orario" value="" id="orario"/>
				<input type="hidden" name="sala" value="" id="sala"/>
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
					<input type="text" name="cognome" id="cognome" class="form-control" placeholder="Cognome"
						   required="true">
					<span class="help-block"></span>
				</div>

				<div class="col-xs-6">
					<label>Telefono</label>
					<input type="text" name="tel" id="tel" class="form-control" placeholder="Telefono"
						   required="true">
					<span class="help-block"></span>
				</div>

				<div class="col-xs-12">
					<label>Note</label>
					<textarea class="form-control" name='note' id='note' style="height: 150px;"
							  placeholder="Inserire qui eventuali note..."></textarea>
				</div>
			</fieldset>
			<br>

			<div class="col-xs-12">
				<button onclick="controllo();" class="btn btn-primary" type="button">
					Invia prenotazione
				</button>
			</div>
			<br>
		</div>
	</div>
	<br>
</form>
<script>
	fase1();
	ricercaFasiDisponibili();
</script>