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

	$nome = $_POST["nomeSala"];
	$n = $_POST["numeroPosti"];

	$query = "INSERT INTO sale (Nome_sala, Numero_posti_prenotabili)
	VALUES ('" . $nome . "', '" . $n . "');";

    if($connessione->query($query))
        echo "<script> window.location.href = '../elenchi/sale.php?messaggio=Sala inserita correttamente!';</script>";
    else
        echo "<script> window.location.href = '../elenchi/sale.php?alert=Errore nel inserimento della sala!';</script>";

	mysqli_close($connessione);
?>