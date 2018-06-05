<?php
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

    $data = $_GET["date"];
    $giornoSettimana = date('N', strtotime($data)) - 1;
    $anno = substr($data, 0, 4);
    $data_supporto = "x" . substr($data, 4);

    // echo $giornoSettimana;

    $query = "SELECT * FROM Stagioni INNER JOIN
	Stagioni_orari on stagioni.id_stagione = stagioni_orari.id_stagione WHERE 
	((giorno_inizio <= '" . $data .
        "' AND giorno_fine >= '" . $data .
        "' AND giorno_settimana = " . $giornoSettimana . ") OR
	(giorno_inizio = '" . $data_supporto . "' AND giorno_fine = '" . $data_supporto . "'))
	ORDER BY priorita DESC, giorno_inizio DESC;";

    $result = $connessione->query($query);
    $num_row1 = $result->num_rows;

    if ($num_row1 == 0)
        echo "<p style='height: 34px; line-height: 34px;'>Nessuna fase disponibile.</p>";
    else {
        // Prendo il primo risultato
        $row1 = $result->fetch_assoc();
        $idStagione = $row1["id_stagione"];
        $idFascia = $row1["id_fascia"];

        // Ricerca 
        $query = "SELECT DISTINCT fase FROM fasceorarie WHERE id_fascia = " . $idFascia . ";";

        $result = $connessione->query($query);
        $numFasi = $result->num_rows;

        if ($numFasi == 0)
            echo "<p style='height: 34px; line-height: 34px;'>Nessuna fase disponibile.</p>";
        else {
            $fasiNomi = array("Colazione", "Brunch", "Pranzo", "Aperitivo", "Cena", "Serata");
            $finale = '<select class="form-control" id="fase" name="fase">';

            for ($i = 0; $i < $numFasi; $i++) {
                $row2 = $result->fetch_assoc();

                $finale .= "<option value='" . $row2["fase"] . "'>" . $fasiNomi[$row2["fase"]] . "</option>";
            }
            echo $finale . "</select>" . "<input type='hidden' name='stagione' value='" . $idStagione . "'/>";
        }
    }

    mysqli_close($connessione);
}
?>