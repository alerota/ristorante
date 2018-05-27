
<?php

	$today = date("Y-n-j");
	
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";

	$connessione = mysqli_connect($host, $user, $pass);
	$db_selected=mysqli_select_db($connessione, $dbname);

	// Prenotazioni giornaliere totali
	
	$sql = "SELECT COUNT(*) AS totale FROM prenotazioni WHERE giorno = '" . $today . "';";
	
	$result1 = mysqli_query($connessione, $sql);
	
	if($result1)
	{
		$row = mysqli_fetch_array($result1);
		$a1 = $row["totale"];
	}
	else
		$a1 = 0;
	
	// Prenotazioni aperte
	
	$sql = "SELECT COUNT(*) AS totale FROM prenotazioni WHERE giorno = '" . $today . "' and chiusura = 0;";
	
	$result2 = mysqli_query($connessione, $sql);
	
	if($result2)
	{
		$row = mysqli_fetch_array($result2);
		$a2 = $row["totale"];
	}
	else
		$a2 = 0;
	
	// Prenotati arrivati
	
	$sql = "SELECT COUNT(*) AS totale FROM prenotazioni WHERE giorno = '" . $today . "' and chiusura = 0 and arrivo = 1;";
	
	$result3 = mysqli_query($connessione, $sql);
	
	if($result3)
	{
		$row = mysqli_fetch_array($result3);
		$a3 = $row["totale"];
	}
	else
		$a3 = 0;
	
	// Prenotazioni scadute
	
	$sql = "SELECT COUNT(*) AS totale FROM prenotazioni WHERE giorno = '" . $today . "' and chiusura = 0 and scadenza = 1;";
	
	$result4 = mysqli_query($connessione, $sql);
	
	if($result4)
	{
		$row = mysqli_fetch_array($result4);
		$a4 = $row["totale"];
	}
	else
		$a4 = 0;
	
	// Prenotazioni scadute
	
	$sql = "SELECT COUNT(*) AS totale FROM prenotazionidarevisionare;";
	
	$result5 = mysqli_query($connessione, $sql);
	
	if($result5)
	{
		$row = mysqli_fetch_array($result5);
		$a5 = $row["totale"];
	}
	else
		$a5 = 0;
	
	echo "<hr><h3 style='text-align: center;'>Dati odierni</h3><br>";
	
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'prenotazioni.php?date=' . $today . '\';" class="btn btn-primary center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-user"></div> Totale: <strong>' . $a1 . '</strong></h4>
		</button></div>';
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'prenotazioni.php?date=' . $today . '\';" class="btn btn-primary center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-cutlery"></div> A tavola: <strong>' . $a3 . '</strong></h4>
		</button></div>';
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'prenotazioni.php?date=' . $today . '\';" class="btn btn-primary center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-time"></div> Prenotazioni aperte: <strong>' . $a2 . '</strong></h4>
		</button></div>';
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'prenotazioni.php?date=' . $today . '\';" class="btn btn-warning center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-alert"></div> Scaduti: <strong>' . $a4 . '</strong></h4>
		</button></div>';
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'revisionare.php\';" class="btn btn-danger center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-remove"></div> Revisioni: <strong>' . $a5 . '</strong></h4>
		</button></div>';
	
	echo '<div class="info col-md-3"><button onclick="" class="btn btn-fourth center-block" type="button" style="width: 100%; ">
				<h4 class="glyphicon glyphicon-save"></h4>
		</button></div>';
	echo '<div class="info col-md-3"><button onclick="" class="btn btn-fourth center-block" type="button" style="width: 100%; ">
				<h4 class="glyphicon glyphicon-send"></h4>
		</button></div>';
	
	
	

?>