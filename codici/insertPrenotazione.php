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
	{
		$sql2 = "INSERT INTO storico ('nome_cliente', 'tel_cliente') VALUES ('" . $nome . "', '" . $tel . "');";
		$result = mysqli_query($connessione, $sql2);
		
        header("Location: ../index.php?messaggio=Ricordiamo che la prenotazione verrà annullata per ritardo maggiore di 20 minuti.");
    }
	else
        header("Location: ../index.php?alert=Si sono verificati problemi durante l'invio della prenotazione, si prega di contattare il ristorante.");

	mysqli_close($connessione);

?>