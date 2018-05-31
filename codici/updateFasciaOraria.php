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

    if($_POST != null) {
        $idFascia = $_POST['nomeFascia'];

        $orari = array();
        for($i=0; $i < 6; $i++) {
            if(isset($_POST["orario" . $i]))
                $orari[$i] = $_POST["orario" . $i];
            else
                $orari[$i] = null;
        }
        print_r($orari);

        $query = "SELECT * FROM fasceorarie WHERE id_fascia = '$idFascia'";
        $result = $connessione->query($query);
        $num_rows = $result->num_rows;

        if($num_rows != 0) {
            for($i = 0; $i < $num_rows; $i++) {
                $orariDB = mysqli_fetch_row($result);
                $ris = array_search($orariDB[2], $orari[$orariDB[3]]);

                if ($ris === false) {
                    $query2 = "SELECT * FROM prenotazioni NATURAL JOIN stagioni_orari WHERE orario='$orariDB[2]' AND id_fascia = '$idFascia'";
                    $result2 = $connessione->query($query2);
                    $num_rows2 = $result2->num_rows;

                    if ($num_rows2 != 0) {
                        while ($pren = $result2->fetch_assoc()) {
                            $query3 = "INSERT INTO prenotazionidarevisionare(`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`) VALUES ('" . $pren["cliente"] . "','" . $pren["tel"] . "','" . $pren["num_partecipanti"] . "','" . $pren["giorno"] . "','" . $pren["orario"] . "','" . $pren["id_sala"] . "','" . $pren["id_stagione"] . "','" . $pren["id_fase"] . "','" . $pren["note_prenotazione"] . "')";
                            $result3 = $connessione->query($query3);
                        }
                        $query4 = "DELETE prenotazioni.* FROM prenotazioni NATURAL JOIN stagioni_orari WHERE orario='$orariDB[2]' AND id_fascia = '$idFascia'";
                        $result4 = $connessione->query($query4);
                    }

                    $query5 = "DELETE FROM fasceorarie WHERE orario='$orariDB[2]' AND id_fascia = '$idFascia'";
                    $result5 = $connessione->query($query5);
                    if (!$result5)
                        echo "errore";
                    else
                        echo "<script> window.location.href = '../forms/AggiuntaNuovaFasciaOraria.php?alert=Siamo bravi'</script>";

                }
                else {
                    $orari[$orariDB[3]][$ris] = null;
                }
            }
        }
        else {
            echo "errore";
        }

        echo "<br>";
        print_r($orari);
    }
    else {
        mysqli_close($connessione);
        echo "<script> window.location.href = '../forms/AggiuntaNuovaFasciaOraria.php?alert=Errore nel caricamento della fascia'</script>";
    }
?>