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
		echo "La sala è stata inserita correttamente<br>";
	else
		echo "Errore: " . $sql . "<br>" . mysqli_error($connessione);

	mysqli_close($connessione);

?>