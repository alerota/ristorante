<?php
    $connessione = _conn();
    
	function gestioneEccezioneVirgolette($testo)
	{
		while(strpos($testo, "\"") !== false)
			$testo = str_replace("\"", "``", $testo);
		while(strpos($testo, "'") !== false)
			$testo = str_replace("'", "`", $testo);
		return $testo;
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
		
        for($i=0; $i < 6; $i++) {
			if($orari[$i] != null)
			{
				for($j=0; $j < sizeof($orari[$i]); $j++)
					echo $orari[$i][$j] . " - ";
				echo "<br>";
			}
		}
		
        $query = "SELECT * FROM fasceorarie WHERE id_fascia = '$idFascia'";
        $result = $connessione->query($query);
        $num_rows = $result->num_rows;

        if($num_rows != 0) {
            for($i = 0; $i < $num_rows; $i++) {
                $orariDB = mysqli_fetch_row($result);
                $ris = array_search($orariDB[2], $orari[$orariDB[3]]);

                if ($ris === false) {

                    $query2 = "SELECT DISTINCT * FROM prenotazioni NATURAL JOIN stagioni_orari WHERE orario='$orariDB[2]' AND id_fascia = '$idFascia' GROUP BY id_prenotazione";
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
                        echo "<script> window.location.href = '../../forms/AggiuntaNuovaFasciaOraria.php'</script>";

                }
                else {
                    $orari[$orariDB[3]][$ris] = null;
                }
            }

            if(count($orari) != 0)
                _aggiungiNuovi($orari, $idFascia);
            else
                echo "<script> window.location.href = '../../forms/AggiuntaNuovaFasciaOraria.php'</script>";
        }
        else {
            echo "erroreasdhjkfasdf";
        }

        echo "<br>";
    }
    else {
        mysqli_close($connessione);
        echo "<script> window.location.href = '../../forms/AggiuntaNuovaFasciaOraria.php'</script>";
    }


    function _conn() {
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

    function _aggiungiNuovi($orari, $idFascia) {
        $connessione = _conn();

        for($i = 0; $i < count($orari); $i++) {
            if($orari[$i] != null) {
                for($j = 0; $j < count($orari[$i]); $j++) {
                    if($orari[$i][$j] != null) {
                        $query = "INSERT INTO fasceorarie(`id_fascia`, `orario`, `fase`) VALUES ('" . $idFascia . "','" . $orari[$i][$j] . "','" . $i . "')";
                        $result = $connessione->query($query);
                        if (!$result)
                            echo "errore" . $i;
                    }
                }
            }
        }

        echo "<script> window.location.href = '../../forms/AggiuntaNuovaFasciaOraria.php'</script>";
    }
?>

