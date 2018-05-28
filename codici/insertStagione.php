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

	$nome = $_POST["nomeStagione"];
	$priorita = $_POST["prioritaStagione"];
	$inizio = $_POST["inizioStagione"];
	$fine = $_POST["fineStagione"];
	$giorni = $_POST["giorni"];
	$sale = $_POST['sala'];

	
	// Fase 1: inserimento della stagione effettiva
	$query = "INSERT INTO stagioni (nome_stagione, giorno_inizio, giorno_fine, priorita)
	VALUES ('" . $nome . "', '" . $inizio . "', '" . $fine . "', '" . $priorita . "');";

    if (!($connessione->query($query)))
        echo "<script> window.location.href = '../elenchi/stagioni_giornoSpeciale.php?error=Errore nel inserimento della stagione!';</script>";


	// Fase 2: inserimento degli orari
	$idStagione = mysqli_insert_id($connessione);
	
	$supporto = "INSERT INTO stagioni_orari (id_stagione, giorno_settimana, id_fascia) VALUES ";
	for($i=0; $i < 7; $i++)
	{
		$supporto .= "('" . $idStagione . "', '" . $i . "', '" . $giorni[$i] . "')";
		if($i + 1 == 7)
			$supporto .= ";";
		else
			$supporto .= ", ";
	}

    if (!($connessione->query($supporto)))
        echo "<script> window.location.href = '../elenchi/stagioni_giornoSpeciale.php?error=Errore nel inserimento della stagione!';</script>";


	// Fase 3: inserimento delle sale
	$supporto = "INSERT INTO stagioni_sale (id_stagione, id_sala) VALUES ";
	
	$n = count($sale);
	for($i=0; $i < $n; $i++)
	{
		if($sale[$i] != null && $sale[$i] != "")
		{
			$supporto .= "('" . $idStagione . "', '" . $sale[$i] . "')";
			if($i + 1 == $n)
				$supporto .= ";";
			else
				$supporto .= ", ";
		}
	}

    if (!($connessione->query($supporto)))
        echo "<script> window.location.href = '../elenchi/stagioni_giornoSpeciale.php?error=Errore nel inserimento della stagione!';</script>";

    echo "<script> window.location.href = '../elenchi/stagioni_giornoSpeciale.php?messaggio=Stagione inserita correttamente!';</script>";
	
	mysqli_close($connessione);
?>