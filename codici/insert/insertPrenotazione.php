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
    echo '<script> window.location.href= "http://localhost/ristorante/index.php";</script>';
    exit();
}
else {
    // Connessione al DB
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ristorante";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }

    $data = $_POST["giornata"];
    $n = $_POST["num_persone"];
    $orario = $_POST["orario"];
    $sala = $_POST["sala"];
    $nome = gestioneEccezioneVirgolette($_POST["cognome"]);
    $tel = $_POST["tel"];
    $note = gestioneEccezioneVirgolette($_POST["note"]);
    $fase = $_POST["fase123"];
    $stagione = $_POST["stagione"];

    $query = "INSERT INTO prenotazioni (`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`, `scadenza`, `arrivo`, `chiusura`) 
	VALUES ('" . $nome . "', '" . $tel . "', '" . $n . "', '" . $data . "', '" . $orario . "', '" . $sala . "', '" . $stagione . "', '" . $fase . "', '" . $note . "', 0, 0, 0);";


    if (!($connessione->query($query)))
        echo "<script> window.location.href = '../../index.php';</script>";
    else {

        $query2 = "INSERT INTO storico (`nome_cliente`, `tel_cliente`) VALUES ('" . $nome . "', '" . $tel . "');";
        // echo $query2 . "<br>";
        $result = $connessione->query($query2);

        // echo mysqli_errno($connessione) . " - " . mysqli_error($connessione);

        if (!$result)
            echo "<script> window.location.href = '../../index.php';</script>";
        else
            echo "<script> window.location.href = '../../index.php';</script>";

    }

    mysqli_close($connessione);
}
?>