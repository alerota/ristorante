<?php
    
	function gestioneEccezioneVirgolette($testo)
	{
		while(strpos($testo, "\"") !== false)
			$testo = str_replace("\"", "``", $testo);
		while(strpos($testo, "'") !== false)
			$testo = str_replace("'", "`", $testo);
		return $testo;
	}
	
	// Connessione al DB
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }
	
	$idFascia = $_POST["giorno0"];
	$ripetizione = $_POST["ripetizioneGiorno"];
	$nome = gestioneEccezioneVirgolette($_POST["nomeGiorno"]);
	$giorno = $_POST["giornata"];
	
	if($ripetizione == "1")
		$giorno = "x" . substr($giorno, strpos($giorno, "-"));
	
	$sale = $_POST['sala'];

	
	// Fase 1: inserimento della stagione effettiva
    $query = "INSERT INTO stagioni (nome_stagione, giorno_inizio, giorno_fine, priorita) VALUES ('" . $nome . "', '" . $giorno . "', '" . $giorno . "', 11);";

    if (!($connessione->query($query)))
        echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php';</script>";

	
	// Fase 2: inserimento degli orari
    $idStagione = mysqli_insert_id($connessione);

    $supporto = "INSERT INTO stagioni_orari (id_stagione, giorno_settimana, id_fascia) VALUES ";
    for($i=0; $i < 7; $i++) {
        $supporto .= "('" . $idStagione . "', '" . $i . "', '" . $idFascia . "')";
        if($i + 1 == 7)
            $supporto .= ";";
        else
            $supporto .= ", ";
    }

    if (!($connessione->query($supporto)))
        echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php';</script>";

	
	// Fase 3: inserimento delle sale
	$supporto = "INSERT INTO stagioni_sale (id_stagione, id_sala) VALUES ";
	
	$n = count($sale);
	for($i=0; $i < $n; $i++) {
		if($sale[$i] != null && $sale[$i] != "") {
			$supporto .= "('" . $idStagione . "', '" . $sale[$i] . "')";
			if($i + 1 == $n)
				$supporto .= ";";
			else
				$supporto .= ", ";
		}
	}

    if (!($connessione->query($supporto)))
        echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php';</script>";


    echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php';</script>";
	
	mysqli_close($connessione);
?>