<?php
    // Connessione al DB
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ristorante";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }

    $today = date("Y-m-d");


	// Prenotazioni giornaliere totali
	$query1 = "SELECT COUNT(*) AS totale FROM prenotazioni WHERE giorno = '" . $today . "';";
	$result1 = $connessione->query($query1);
	if($result1) {
        $row = $result1->fetch_assoc();
		$a1 = $row["totale"];
	}
	else
		$a1 = 0;


	// Prenotazioni aperte
    $query2 = "SELECT COUNT(*) AS totale FROM prenotazioni WHERE giorno = '" . $today . "' and chiusura = 0;";
    $result2 = $connessione->query($query2);
    if($result2) {
        $row = $result2->fetch_assoc();
        $a2 = $row["totale"];
    }
    else
        $a2 = 0;


	// Prenotati arrivati
	$query3 = "SELECT COUNT(*) AS totale FROM prenotazioni WHERE giorno = '" . $today . "' and chiusura = 0 and arrivo = 1;";
    $result3 = $connessione->query($query3);
    if($result3) {
        $row = $result3->fetch_assoc();
        $a3 = $row["totale"];
    }
    else
        $a3 = 0;


	// Prenotazioni scadute
	$query4 = "SELECT COUNT(*) AS totale FROM prenotazioni WHERE giorno = '" . $today . "' and chiusura = 0 and scadenza = 1;";
    $result4 = $connessione->query($query4);
    if($result4) {
        $row = $result4->fetch_assoc();
        $a4 = $row["totale"];
    }
    else
        $a4 = 0;


	// Prenotazioni scadute
	$query5 = "SELECT COUNT(*) AS totale FROM prenotazionidarevisionare;";
	$result5 = $connessione->query($query5);
    if($result5) {
        $row = $result5->fetch_assoc();
        $a5 = $row["totale"];
    }
    else
        $a5 = 0;
	
	echo "<hr><h3 style='text-align: center;'>Dati odierni</h3><br>";
	
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'elenchi/prenotazioni.php?date=' . $today . '\';" class="btn btn-primary center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-user"></div> Totale: <strong>' . $a1 . '</strong></h4>
		</button></div>';
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'elenchi/prenotazioni.php?date=' . $today . '\';" class="btn btn-primary center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-cutlery"></div> A tavola: <strong>' . $a3 . '</strong></h4>
		</button></div>';
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'elenchi/prenotazioni.php?date=' . $today . '\';" class="btn btn-primary center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-time"></div> Pren. aperte: <strong>' . $a2 . '</strong></h4>
		</button></div>';
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'elenchi/prenotazioni.php?date=' . $today . '\';" class="btn btn-warning center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-alert"></div> Scaduti: <strong>' . $a4 . '</strong></h4>
		</button></div>';
	echo '<div class="info col-md-6"><button onclick="window.location.href=\'elenchi/revisionare.php\';" class="btn btn-danger center-block" type="button" style="width: 100%; ">
				<h4><div class="glyphicon glyphicon-remove"></div> Revisioni: <strong>' . $a5 . '</strong></h4>
		</button></div>';
	
	echo '<div class="info col-md-3"><button onclick="window.location.href=\'codici/creaElencoGiornaliero.php?t=file&data=' . date("Y-m-d") . '\';" class="btn btn-fourth center-block" type="button" style="width: 100%; ">
				<h4 class="glyphicon glyphicon-save"></h4>
		</button></div>';
	echo '<div class="info col-md-3"><button onclick="window.location.href=\'codici/creaElencoGiornaliero.php?t=mail&data=' . date("Y-m-d") . '\';" class="btn btn-fourth center-block" type="button" style="width: 100%; ">
				<h4 class="glyphicon glyphicon-send"></h4>
		</button></div>';

    mysqli_close($connessione);
?>