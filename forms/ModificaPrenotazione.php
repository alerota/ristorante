<?php

	if(isset($_GET["msg"]))
	{
		$idImportante = $_GET["msg"];
		
		// Connessione al DB
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "ristorante";

        $connessione = new mysqli($host, $user, $pass, $dbname);

        if ($connessione->connect_errno) {
            echo "Errore in connessione al DBMS: " . $connessione->error;
        }
		
		if($_GET["t"] == "r")
				$query = "SELECT * FROM prenotazionidarevisionare LEFT JOIN sale on prenotazionidarevisionare.id_sala = sale.id_sala WHERE id_prenotazione = $idImportante;";
			else if($_GET["t"] == "n")
				$query = "SELECT * FROM prenotazioni LEFT JOIN sale on prenotazioni.id_sala = sale.id_sala WHERE id_prenotazione = $idImportante;";
		else
		{
			echo "<br>ErrBadTypeEditOrder";
			exit(-2);
		}
		$result = $connessione->query($query);
		
		if($result)
		{
			$row = $result->fetch_assoc();
			
			$nome = $row["cliente"];
			$tel = $row["tel"];
			$note = $row["note_prenotazione"];
			$partecipanti = $row["num_partecipanti"];
			if(isset($row["Nome_sala"]))
				$sala = $row["Nome_sala"];
			else
				$sala = "x";
			$giornata = date("Y-m-d", strtotime($row["giorno"]));
			$orario = $row["orario"];
		}
	}
	else
		exit(-1);
?>
<script>
function isMobile()
{
	return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf("IEMobile") !== -1);
}
function controllo()
{
	document.getElementById('formPrenotazione').submit();
}
function fase3(a, b)
{
	document.getElementById("orario").value = a;
	document.getElementById("sala").value = b;
	if(document.getElementById("l1").classList.contains("active"))
		document.getElementById("l1").classList.remove("active");
	if(document.getElementById("l2").classList.contains("active"))
		document.getElementById("l2").classList.remove("active");
	if(!document.getElementById("l3").classList.contains("active"))
		document.getElementById("l3").classList.add("active");
	document.getElementById('verify').style.display = 'none';
	document.getElementById('choice').style.display = 'none';
	document.getElementById('details').style.display = 'block';
	if(isMobile())
		document.getElementById('formPrenotazione').style.height = (140 + document.getElementById('details').offsetHeight) + "px";
}
function ricercaSicura()
{
	ricercaSaleAdmin();
	if(document.getElementById("l1").classList.contains("active"))
		document.getElementById("l1").classList.remove("active");
	if(!document.getElementById("l2").classList.contains("active"))
		document.getElementById("l2").classList.add("active");
	if(document.getElementById("l3").classList.contains("active"))
		document.getElementById("l3").classList.remove("active");
	document.getElementById('verify').style.display = 'none';
	document.getElementById('choice').style.display = 'block';
	document.getElementById('details').style.display = 'none';
	if(isMobile())
		document.getElementById('formPrenotazione').style.height = (70 + document.getElementById('choice').offsetHeight) + "px";
}
function fase2()
{
	ricercaSaleDisponibili();
	
	if(document.getElementById("l1").classList.contains("active"))
		document.getElementById("l1").classList.remove("active");
	if(!document.getElementById("l2").classList.contains("active"))
		document.getElementById("l2").classList.add("active");
	if(document.getElementById("l3").classList.contains("active"))
		document.getElementById("l3").classList.remove("active");
	document.getElementById('verify').style.display = 'none';
	document.getElementById('choice').style.display = 'block';
	document.getElementById('details').style.display = 'none';
	if(isMobile())
		document.getElementById('formPrenotazione').style.height = (70 + document.getElementById('choice').offsetHeight) + "px";
}
function fase1()
{
	if(!document.getElementById("l1").classList.contains("active"))
		document.getElementById("l1").classList.add("active");
	if(document.getElementById("l2").classList.contains("active"))
		document.getElementById("l2").classList.remove("active");
	if(document.getElementById("l3").classList.contains("active"))
		document.getElementById("l3").classList.remove("active");
	document.getElementById('details').style.display = 'none';
	document.getElementById('choice').style.display = 'none';
	document.getElementById('verify').style.display = 'block';
}
var req;
function loadDoc(url, postvalue) 
{
   req = getAjaxControl();
   if(req) {
      req.open("POST", url, false); // sincrono
      req.setRequestHeader("Content-Type", "text/xml")
      req.send(postvalue);
   }
}
function getAjaxControl() 
{
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
	loadDoc("../codici/ricerca/ricercaFasi.php?date=" + document.getElementById("data").value,"");
    document.getElementById("selezioneFasi").innerHTML=req.responseText;
}
function ricercaSaleDisponibili()
{
	var numeroPersone = document.getElementById("numero").value;
	var faseScelta = document.getElementById("fase").value;
	var dataScelta = document.getElementById("data").value;
	
	if(numeroPersone > 0)
	{
		loadDoc("../codici/ricerca/ricercaFasciaOraria.php?date=" + dataScelta + "&numeroPartecipanti=" + numeroPersone + "&fase=" + faseScelta,""); // Rivedi qui
		document.getElementById("selezioneSale").innerHTML=req.responseText;
	}
	else
		alert("Inserire il numero di partecipanti!");
}
function ricercaSaleAdmin()
{
	var numeroPersone = document.getElementById("numero").value;
	var faseScelta = document.getElementById("fase").value;
	var dataScelta = document.getElementById("data").value;
	
	if(numeroPersone > 0)
	{
		loadDoc("../codici/ricerca/ricercaFasciaOrariaAdmin.php?date=" + dataScelta + "&fase=" + faseScelta,""); // Rivedi qui
		document.getElementById("selezioneSale").innerHTML=req.responseText;
	}
	else
		alert("Inserire il numero di partecipanti!");
}
</script>

<style>
.sceltaSala { margin: 0px 0px 10px 10px; }
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

<?php include '../menu.php'; ?>
<div class="container">
	<div class="row">
		<div class="col-md-4"> <?php include "listino.php"; ?> </div>
		<div class="col-md-1"><br></div>
		<div class="col-md-7">
			<form method='POST' id="formPrenotazione" class='form' action="../codici/update/updatePrenotazione.php" style='background-color: white; height: calc(100% - 52px); '>
				<input type="hidden" name="tipo" value="<?php echo $_GET["t"]; ?>">
				<input type="hidden" name="id" value="<?php echo $_GET["msg"]; ?>">
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
							<div class="col-xs-6">
								<label>Cognome</label>
								<input type="text" name="nome" class="form-control" id="nome" 
								<?php echo "value = '" . $nome . "' "; ?>
								placeholder="Cognome">
								<span class="help-block"></span>
							</div>
							<div class="col-xs-6">
								<label>Giorno</label>
								<input type="date" onchange="ricercaFasiDisponibili();" name="data" class="form-control" id="data" 
								<?php if(isset($giornata)) echo "value = '" . $giornata . "' "; ?> >
								<span class="help-block"></span>
							</div>
							<div class="col-xs-2">
								<a data-toggle="tooltip" title="Definisci il numero di partecipanti">
									<label>Prenotati</label>
								</a>
								<input type="number" min="1" name="num_persone" class="form-control" id="numero" 
								<?php echo "value = '" . $partecipanti . "' "; ?> 
								placeholder="Numero">
								<span class="help-block"></span>
							</div>
							<div class="col-xs-5">
								<label>Telefono</label>
								<input type="text" name="tel" class="form-control" id="tel" 
								<?php echo "value = '" . $tel . "' "; ?> 
								placeholder="Telefono">
								<span class="help-block"></span>
							</div>
							<div class="col-xs-5">
								<label for="fase">Fase</label>
								<div id="selezioneFasi" onload="ricercaFasiDisponibili();"></div>
							</div>
						</fieldset>
						<br>
						<div class="col-xs-12">
							<button onclick="fase2();" class="btn btn-primary" type="button" id="verifyButton">
									Conferma dati
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
								<legend>Dettagli aggiuntivi</legend>
							</div>
							
							<div class="col-xs-12">
								<label>Note</label>
								<textarea class="form-control" name='note' id='note' style="height: 150px;" 
								
								placeholder="Inserire qui eventuali note..."><?php echo $note; ?></textarea>
							</div>
						</fieldset>
						<br>
						
						<div class="col-xs-12">
							<button onclick="controllo();" class="btn btn-primary" type="button">
								Aggiorna prenotazione
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
fase1();
ricercaFasiDisponibili();
</script>