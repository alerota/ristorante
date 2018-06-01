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

if(isset($_GET['id'])) {
    $idSala = $_GET['id'];

    $query = "SELECT * FROM prenotazioni WHERE id_sala='$idSala'";
    $result = $connessione->query($query);

    if ($result->num_rows != 0) {
        while ($pren = $result->fetch_assoc()) {
            $query2 = "INSERT INTO prenotazionidarevisionare(`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`) VALUES ('" . $pren["cliente"] . "','" . $pren["tel"] . "','" . $pren["num_partecipanti"] . "','" . $pren["giorno"] . "','" . $pren["orario"] . "','" . $pren["id_sala"] . "','" . $pren["id_stagione"] . "','" . $pren["id_fase"] . "','" . $pren["note_prenotazione"] . "')";
            $result2 = $connessione->query($query2);
        }

        $query3 = "DELETE FROM prenotazioni WHERE id_sala = '$idSala'";
        $result3 = $connessione->query($query3);
    }

    $query = "DELETE FROM stagioni_sale WHERE id_sala = '$idSala'";
    $result = $connessione->query($query);

    $query = "DELETE FROM sale WHERE id_sala = '$idSala'";
    $result = $connessione->query($query);

    echo "<script> window.location.href = '../elenchi/sale.php?messaggio=Sala cancellata correttamente!'</script>";
}

mysqli_close($connessione);
?>