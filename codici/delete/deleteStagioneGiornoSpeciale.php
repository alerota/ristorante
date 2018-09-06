<?php
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

    if (isset($_GET['id'])) {
        $idStagione = $_GET['id'];

        $query = "SELECT * FROM prenotazioni WHERE id_stagione='$idStagione'";

        $result = $connessione->query($query);

        if ($result) {
            $numrows = $result->num_rows;

            if ($numrows != 0) {
                while ($pren = $result->fetch_assoc()) {
                    $query2 = "INSERT INTO prenotazionidarevisionare(`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`) VALUES ('" . $pren["cliente"] . "','" . $pren["tel"] . "','" . $pren["num_partecipanti"] . "','" . $pren["giorno"] . "','" . $pren["orario"] . "','" . $pren["id_sala"] . "','" . $pren["id_stagione"] . "','" . $pren["id_fase"] . "','" . $pren["note_prenotazione"] . "')";
                    $result2 = $connessione->query($query2);
                }

                $query3 = "DELETE FROM prenotazioni WHERE id_stagione = '$idStagione'";
                $result3 = $connessione->query($query3);
            }

            $query = "DELETE FROM stagioni WHERE id_stagione = '$idStagione'";
            $result = $connessione->query($query);

            $query = "DELETE FROM stagioni_orari WHERE id_stagione = '$idStagione'";
            $result = $connessione->query($query);

            $query = "DELETE FROM stagioni_sale WHERE id_stagione = '$idStagione'";
            $result = $connessione->query($query);

            echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?messaggio=Cancellazione effettuata con successo!'</script>";
        }
    }

    mysqli_close($connessione);
}
?>