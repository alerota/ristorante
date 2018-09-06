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

    $nome = gestioneEccezioneVirgolette($_POST["nomeFascia"]);

    $orari = array();
    for ($i = 0; $i < 6; $i++) {
        if (isset($_POST["orario" . $i]))
            $orari[$i] = $_POST["orario" . $i];
        else
            $orari[$i] = null;
    }

    $query = "SELECT MAX(id_fascia) As massimo FROM gestionefasceorarie";
    $result = $connessione->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $id = $row["massimo"] + 1;
    } else
        $id = 1;

    $query = "INSERT INTO gestionefasceorarie (`nome`, `id_fascia`) VALUES ('" . $nome . "', '" . $id . "')";
    $result = $connessione->query($query);

    // echo mysqli_errno($connessione) . " - " . mysqli_error($connessione);

    if ($result) {
        $query = "INSERT INTO fasceorarie (`id_fascia`, `orario`, `fase`) VALUES ";
        for ($i = 0; $i < 6; $i++) {
            if (sizeof($orari[$i]) > 0)
                for ($j = 0; $j < sizeof($orari[$i]); $j++)
                    if ($orari[$i][$j] != "")
                        $query .= "('" . $id . "', '" . $orari[$i][$j] . "', '" . $i . "'),";
        }
        $query = substr($query, 0, strlen($query) - 1) . ";";

        if ($connessione->query($query))
            echo "<script> window.location.href = '../../index.php';</script>";
        else
            echo "<script> window.location.href = '../../index.php';</script>";

    } else
        echo "<script> window.location.href = '../../index.php';</script>";

    mysqli_close($connessione);
}
?>