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
	
	$nome = gestioneEccezioneVirgolette($_POST["nome"]);
	$giorno = $_POST["data"];

	
	// Fase 1: inserimento della stagione effettiva
    $query = "INSERT INTO stagioni (nome_stagione, giorno_inizio, giorno_fine, priorita) VALUES ('" . $nome . "', '" . $giorno . "', '" . $giorno . "', 11);";

    if (!($connessione->query($query)))
        echo "<script> window.location.href = '../../../index.php'inserimento della festa!';</script>";

	
	// Fase 2: inserimento degli orari
    $idStagione = mysqli_insert_id($connessione);

    $supporto = "INSERT INTO stagioni_orari (id_stagione, giorno_settimana, id_fascia) VALUES ";
    for($i=0; $i < 7; $i++) {
        $supporto .= "('" . $idStagione . "', '" . $i . "', '-2')";
        if($i + 1 == 7)
            $supporto .= ";";
        else
            $supporto .= ", ";
    }

    if (!($connessione->query($supporto)))
        echo "<script> window.location.href = '../../index.php'inserimento della festa!';</script>";
	
	mysqli_close($connessione);
	
    echo "<script> window.location.href = '../../index.php';</script>";
	
?>