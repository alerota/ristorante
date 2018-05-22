<?php

	$nome = $_POST["nomeSala"];
	$n = $_POST["numeroPosti"];

	// Connessione al DB

	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";

	$connessione = mysqli_connect($host, $user, $pass);
	$db_selected=mysqli_select_db($connessione, $dbname);


	$sql = "INSERT INTO sale (Nome_sala, Numero_posti_prenotabili)
	VALUES ('" . $nome . "', '" . $n . "');";

    if (mysqli_query($connessione, $sql))
        header("Location: ../sale.php?messaggio=La sala è stata inserita correttamente");
    else
        header("Location: ../sale.php?alert=Errore nel inserimento");

	mysqli_close($connessione);

?>