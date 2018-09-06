<?php
    
	function gestioneEccezioneVirgolette($testo)
	{
		while(strpos($testo, "\"") !== false)
			$testo = str_replace("\"", "``", $testo);
		while(strpos($testo, "'") !== false)
			$testo = str_replace("'", "`", $testo);
		return $testo;
	}

if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://prenotazioni.ristorante-almolo13.com/index.php";</script>';
    exit();
}
else {
    // Connessione al DB
    $host = "localhost";
    $user = "ristoran_pren";
    $pass = "szc[yPA-hIhB";
    $dbname = "ristoran_prenotazioni";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }

    $nome = gestioneEccezioneVirgolette($_POST["nomeSala"]);
    $n = $_POST["numeroPosti"];

    $query = "INSERT INTO sale (Nome_sala, Numero_posti_prenotabili)
	VALUES ('" . $nome . "', '" . $n . "');";

    if ($connessione->query($query))
        echo "<script> window.location.href = '../../elenchi/sale.php';</script>";
    else
        echo "<script> window.location.href = '../../elenchi/sale.php';</script>";

    mysqli_close($connessione);
}
?>