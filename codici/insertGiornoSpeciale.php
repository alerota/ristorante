<?php

	// Connessione al DB

	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";
	
	$idFascia = $_POST["giorno0"];
	$ripetizione = $_POST["ripetizioneGiorno"];
	$nome = $_POST["nomeGiorno"];
	$giorno = $_POST["giornata"];
	
	if($ripetizione == "1")
		$giorno = "x" . substr($giorno, strpos($giorno, "-"));
	
	$sale = $_POST['sala'];
	
	$connessione = mysqli_connect($host, $user, $pass);
	$db_selected=mysqli_select_db($connessione, $dbname);
	
	// Fase 1: inserimento della stagione effettiva

	$sql = "INSERT INTO stagioni (nome_stagione, giorno_inizio, giorno_fine, priorita)
	VALUES ('" . $nome . "', '" . $giorno . "', '" . $giorno . "', 11);";

	if (mysqli_query($connessione, $sql))
		echo "La giornata è stata inserita correttamente<br>";
	else
		echo "Errore nella fase 1: " . $sql . "<br>" . mysqli_error($connessione);
	
	// Fase 2: inserimento degli orari
	
	$idStagione = mysqli_insert_id($connessione);
	
	$supporto = "INSERT INTO stagioni_orari (id_stagione, giorno_settimana, id_fascia) VALUES ";
	for($i=0; $i < 7; $i++)
	{
		$supporto .= "('" . $idStagione . "', '" . $i . "', '" . $idFascia . "')";
		if($i + 1 == 7)
			$supporto .= ";";
		else
			$supporto .= ", ";
	}
	
	if (mysqli_query($connessione, $supporto))
		echo "L'orario è stato caricato con successo<br>";
	else
		echo "Errore nella fase 2: " . $sql . "<br>" . mysqli_error($connessione);
	
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
	
	if (mysqli_query($connessione, $supporto))
		echo "Le sale sono state inserite con successo<br>";
	else
		echo "Errore nella fase 3: " . $sql . "<br>" . mysqli_error($connessione);
	
	mysqli_close($connessione);

?>