<?php
	
	$data = $_POST["giornata"];
	$n = $_POST["num_persone"];
	$orario = $_POST["orario"];
	$sala = $_POST["sala"];
	$nome = $_POST["cognome"];
	$tel = $_POST["tel"];
	$note = $_POST["note"];
	
	// Connessione al DB

	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";

	$connessione = mysqli_connect($host, $user, $pass);
	$db_selected=mysqli_select_db($connessione, $dbname);


	$sql = "INSERT INTO prenotazioni (`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `note_prenotazione`, `scadenza`, `arrivo`, `chiusura`) 
	VALUES ('" . $nome . "', '" . $tel . "', '" . $n . "', '" . $data . "', '" . $orario . "', '" . $sala . "', '" . $note . "', 0, 0, 0);";
	
    if (mysqli_query($connessione, $sql))
        header("Location: ../index.php?messaggio=La sala è stata inserita correttamente");
    else
        header("Location: ../index.php?alert=Errore nel inserimento");

	mysqli_close($connessione);

?>