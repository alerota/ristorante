<?php

function gestioneEccezioneVirgolette($testo)
{
    while(strpos($testo, "\"") !== false)
        $testo = str_replace("\"", "``", $testo);
    while(strpos($testo, "'") !== false)
        $testo = str_replace("'", "`", $testo);
    return $testo;
}

$connessione = _conn();

if($_POST != null) {
    $id = $_POST["id"];
    $nome = gestioneEccezioneVirgolette($_POST["nomeGiorno"]);
    $idFascia = $_POST["giorno0"];
    $sale = $_POST["sala"];
    $ripetizione = $_POST["ripetizioneGiorno"];
    $giorno = $_POST["giornata"];

    if($ripetizione == "1")
        $giorno = "x" . substr($giorno, strpos($giorno, "-"));


    //salvo il vecchio giorno speciale
    $old = _oldGiorno($id);


    if(!_isUguali($id, $old, $nome, $idFascia, $sale, $giorno)) {
		
        //controllo se ci sono prenotazioni nel giorno vecchio
        $query = "SELECT * FROM prenotazioni WHERE id_stagione = '$id'";
        $result2 = $connessione->query($query);
        $num = mysqli_num_rows($result2);
        if ($num != 0) {
            //inserisco in prenotazioni da revisionare
            while ($pren = $result2->fetch_assoc()) {
                $query3 = "INSERT INTO prenotazionidarevisionare(`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`) VALUES ('" . $pren["cliente"] . "','" . $pren["tel"] . "','" . $pren["num_partecipanti"] . "','" . $pren["giorno"] . "','" . $pren["orario"] . "','" . $pren["id_sala"] . "','" . $pren["id_stagione"] . "','" . $pren["id_fase"] . "','" . $pren["note_prenotazione"] . "')";
                $result3 = $connessione->query($query3);
            }
            $query4 = "DELETE FROM prenotazioni WHERE id_stagione ='$id'";
            $result4 = $connessione->query($query4);

            echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?messaggio=Modifica effettuata correttamente!';</script>";
        } else {
            //se non ci sono prenotazioni in quel giorno, posso modificare il giorno senza problemi
            _updateGiorno($nome, $giorno, $old["id_stagione"], $sale, $idFascia);
        }
    }
    else
        echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?alert=Rispetto a prima non è stato modificato nulla!';</script>";
}

mysqli_close($connessione);

//modifica nella tabella stagioni
function _updateGiorno($nome, $giorno, $idGiornoSpeciale, $sale, $idFascia)
{
    $connessione = _conn();

    $query = "UPDATE stagioni SET nome_stagione ='$nome', giorno_inizio = '$giorno', giorno_fine = '$giorno' WHERE id_stagione = '$idGiornoSpeciale'";

    if ($connessione->query($query)) {
        $query = "DELETE FROM stagioni_sale WHERE id_stagione = '$idGiornoSpeciale'";

        if ($connessione->query($query)) {

            $supporto = "INSERT INTO stagioni_sale (id_stagione, id_sala) VALUES ";

            $n = count($sale);
            for($i=0; $i < $n; $i++) {
                if($sale[$i] != null && $sale[$i] != "") {
                    $supporto .= "('" . $idGiornoSpeciale . "', '" . $sale[$i] . "')";
                    if($i + 1 == $n)
                        $supporto .= ";";
                    else
                        $supporto .= ", ";
                }
            }

            if ($connessione->query($supporto))
			{
                $query = "UPDATE stagioni_orari SET id_fascia = '$idFascia'";
                if ($connessione->query($query))
                    echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?messaggio=Modifica effettuata correttamente!';</script>";
			}
		}

    }
    else
        echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?alert=Errore3 nella modifica del giorno speciale!';</script>";
}

function _conn()
{
    // Connessione al DB
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ristorante";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }
    else
        return $connessione;
}

function _isUguali($id, $old, $nome, $idFascia, $sale, $giorno)
{
    $connessione = _conn();

    if(strcmp($nome, $old["nome_stagione"]) != 0)
        return false;

    if($giorno != $old["giorno_inizio"])
        return false;



    $query = "SELECT * FROM stagioni_orari WHERE id_stagione = ' $id'";
    $result = $connessione->query($query);
    if (!$result)
        echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?alert=Errore2 nella modifica del giorno speciale!';</script>";
    else {
        $temp = $result->fetch_assoc();

        if($temp["id_fascia"] != $idFascia)
            return false;

    }

    $query = "SELECT * FROM stagioni_sale WHERE id_stagione = '$id'";
    $result = $connessione->query($query);
    if (!$result)
        echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?alert=Errore1 nella modifica del giorno speciale!';</script>";
    else {
        if($sale != null && ($result->num_rows) > 0) {
            for ($i = 0; $i < count($sale); $i++) {
                $temp = $result->fetch_assoc();
                if ($sale[$i] != null && $sale[$i] != "") {
                    if ($sale[$i] != $temp["id_sala"])
                        return false;
                }
            }
        }
        else if($sale == null && ($result->num_rows) == 0)
            return true;
        else
            return false;
    }

    mysqli_close($connessione);
    return true;
}

function _oldGiorno($id)
{
    $connessione = _conn();

    $query = "SELECT * FROM stagioni WHERE id_stagione = '$id'";
    $result = $connessione->query($query);

    mysqli_close ($connessione);
    return $result->fetch_assoc();
}
?>