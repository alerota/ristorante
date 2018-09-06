<?php
function correggiDate($inizio, $fine, $restituzione) 
{
    $appoggio;
	if($restituzione)
	{
		if($fine < $inizio)
			return $fine;
		else
			return $inizio;
	}
	else
		if($fine < $inizio)
			return $inizio;
		else
			return $fine;
}
    
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
    $connessione = _conn();

    if ($_POST != null) {
        $id = $_POST["id"];
        $nome = gestioneEccezioneVirgolette($_POST["nomeStagione"]);
        $fasce = $_POST["giorni"];
        if (isset($_POST["sala"]))
            $sale = $_POST["sala"];
        else
            $sale = array();
        $inizio = $_POST["inizioStagione"];
        $fine = $_POST["fineStagione"];

        /* Ora sono certo che inizio sia minore di fine */
        $a = correggiDate($inizio, $fine, true);
        $b = correggiDate($inizio, $fine, false);

        $a1 = updateSale($id, $sale, $connessione);

        $a2 = updateFasce($id, $fasce, $connessione);

        $a3 = _isUguali(_oldStagione($id), $nome, $a, $b);

        if (!$a1 && !$a2 && $a3) {
            echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?alert=Non hai cambiato nulla della vecchia stagione...'; </script>";
        } else {
            if (!$a3) {
                $row = _oldStagione($id);

                if ($a > $row["giorno_inizio"]) {
                    $sql7 = "SELECT * FROM prenotazioni WHERE id_stagione = '$id' and giorno <= '$a';";
                    $result7 = mysqli_query($connessione, $sql7);

                    if ($result7) {
                        while ($pren = mysqli_fetch_assoc($result7)) {
                            $sql9 = "INSERT INTO prenotazionidarevisionare(`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`) VALUES ('" . $pren["cliente"] . "','" . $pren["tel"] . "','" . $pren["num_partecipanti"] . "','" . $pren["giorno"] . "','" . $pren["orario"] . "','" . $pren["id_sala"] . "','" . $pren["id_stagione"] . "','" . $pren["id_fase"] . "','" . $pren["note_prenotazione"] . "')";
                            $result9 = mysqli_query($connessione, $sql9);
                            $sql11 = "DELETE FROM prenotazioni WHERE id_prenotazione = '" . $pren["id_prenotazione"] . "';";
                            $result11 = mysqli_query($connessione, $sql11);
                        }
                    }
                }

                if ($b < $row["giorno_fine"]) {
                    $sql8 = "SELECT * FROM prenotazioni WHERE id_stagione = '$id' and giorno >= '$b';";
                    $result8 = mysqli_query($connessione, $sql8);
                    echo $b . "<br>" . $sql8 . "<br>";
                    if ($result8) {
                        while ($pren = mysqli_fetch_assoc($result8)) {
                            $sql10 = "INSERT INTO prenotazionidarevisionare(`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`) VALUES ('" . $pren["cliente"] . "','" . $pren["tel"] . "','" . $pren["num_partecipanti"] . "','" . $pren["giorno"] . "','" . $pren["orario"] . "','" . $pren["id_sala"] . "','" . $pren["id_stagione"] . "','" . $pren["id_fase"] . "','" . $pren["note_prenotazione"] . "')";
                            $result10 = mysqli_query($connessione, $sql10);
                            $sql12 = "DELETE FROM prenotazioni WHERE id_prenotazione = '" . $pren["id_prenotazione"] . "';";
                            $result12 = mysqli_query($connessione, $sql12);
                        }
                    }
                }

                $sql6 = "UPDATE stagioni SET nome_stagione = '" . $nome . "', giorno_inizio = '" . $a . "', giorno_fine = '" . $b . "' where id_stagione = '$id';";
                $result6 = mysqli_query($connessione, $sql6);

                if (!$result6) {
                    echo "ErrUpdtStgOrrFailedUpdt";
                    exit(-2);
                }
            }
            echo "<script> window.location.href = '../../elenchi/stagioni_giorniSpeciali.php?messaggio=Stagione modificata con successo!'; </script>";
        }

    }

    mysqli_close($connessione);

    function _conn()
    {
        // Connessione al DB
        $host = "localhost";
        $user = "ristoran_pren";
        $pass = "szc[yPA-hIhB";
        $dbname = "ristoran_prenotazioni";

        $connessione = new mysqli($host, $user, $pass, $dbname);

        if ($connessione->connect_errno) {
            echo "Errore in connessione al DBMS: " . $connessione->error;
        } else
            return $connessione;
    }

    function _isUguali($old, $nome, $inizio, $fine)
    {
        return ($old["nome_stagione"] == $nome && $old["giorno_inizio"] == $inizio && $old["giorno_fine"] == $fine);
    }

    function _oldStagione($id)
    {
        $connessione = _conn();

        $query = "SELECT * FROM stagioni WHERE id_stagione = '$id'";
        $result = $connessione->query($query);

        mysqli_close($connessione);
        return $result->fetch_assoc();
    }

    function updateSale($ids, $s, $connessione)
    {
        $sql1 = "SELECT * FROM stagioni_sale WHERE id_stagione = '$ids';";
        $result1 = mysqli_query($connessione, $sql1);
        $ritorno = false;
        if ($s == null)
            $s = array();

        if ($result1) {
            $num1 = mysqli_num_rows($result1);

            for ($i = 0; $i < $num1; $i++) {
                $row = mysqli_fetch_assoc($result1);
                $ris = array_search($row["id_sala"], $s);

                // Se la sala che cerco non è presente nell'array delle nuove sale, controllo le prenotazioni,
                // altrimenti tolgo quella sala dall'array.

                if ($ris === false) {
                    $sql2 = "SELECT * FROM prenotazioni WHERE id_sala = '" . $row["id_sala"] . "' and id_stagione = '$ids';";
                    $result2 = mysqli_query($connessione, $sql2);

                    if ($result2) {
                        $num2 = mysqli_num_rows($result2);
                        for ($j = 0; $j < $num2; $j++) {
                            $pren = mysqli_fetch_assoc($result2);
                            $sql3 = "INSERT INTO prenotazionidarevisionare(`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`) VALUES ('" . $pren["cliente"] . "','" . $pren["tel"] . "','" . $pren["num_partecipanti"] . "','" . $pren["giorno"] . "','" . $pren["orario"] . "','" . $pren["id_sala"] . "','" . $pren["id_stagione"] . "','" . $pren["id_fase"] . "','" . $pren["note_prenotazione"] . "')";
                            $result3 = mysqli_query($connessione, $sql3);
                        }
                        $sql4 = "DELETE FROM prenotazioni where id_sala = '" . $row["id_sala"] . "' and id_stagione = '$ids';";
                        $result4 = mysqli_query($connessione, $sql4);

                        $sql4 = "DELETE FROM stagioni_sale where id_sala = '" . $row["id_sala"] . "' and id_stagione = '$ids';";
                        $result4 = mysqli_query($connessione, $sql4);
                        $ritorno = true;
                        if (!$result4) {
                            echo "ErrUpdtStgSaleFailedRmv";
                            exit(-2);
                        }
                    } else {
                        echo "ErrUpdtStgSaleFailedSearchPren";
                        exit(-2);
                    }
                } else
                    $s[$ris] = null;
            }

            $c = sizeof($s);
            for ($i = 0; $i < $c; $i++) {
                if ($s[$i] != null) {
                    $sql5 = "INSERT INTO stagioni_sale (`id_stagione`, `id_sala`) VALUES ('$ids', '" . $s[$i] . "');";
                    $result5 = mysqli_query($connessione, $sql5);
                    $ritorno = true;
                }
            }
        } else {
            echo "ErrUpdStgMssMatchStg";
            exit(-2);
        }

        return $ritorno;
    }

    function updateFasce($ids, $f, $connessione)
    {
        $sql1 = "SELECT * FROM stagioni_orari WHERE id_stagione = '$ids' order by giorno_settimana;";
        $result1 = mysqli_query($connessione, $sql1);
        $ritorno = false;
        if ($result1 && mysqli_num_rows($result1) == 7) {
            for ($i = 0; $i < 7; $i++) {
                $row = mysqli_fetch_assoc($result1);

                if ($row["id_fascia"] != $f[$i]) {
                    $sql2 = "SELECT * FROM prenotazioni WHERE id_stagione = '$ids';";
                    $result2 = mysqli_query($connessione, $sql2);

                    if ($result2) {
                        $num2 = mysqli_num_rows($result2);
                        for ($j = 0; $j < $num2; $j++) {
                            $pren = mysqli_fetch_assoc($result2);
                            if ((date("w", strtotime($pren["giorno"])) - 1) % 7 == $i) {
                                $sql3 = "INSERT INTO prenotazionidarevisionare(`cliente`, `tel`, `num_partecipanti`, `giorno`, `orario`, `id_sala`, `id_stagione`, `id_fase`, `note_prenotazione`) VALUES ('" . $pren["cliente"] . "','" . $pren["tel"] . "','" . $pren["num_partecipanti"] . "','" . $pren["giorno"] . "','" . $pren["orario"] . "','" . $pren["id_sala"] . "','" . $pren["id_stagione"] . "','" . $pren["id_fase"] . "','" . $pren["note_prenotazione"] . "')";
                                $result3 = mysqli_query($connessione, $sql3);
                                $sql4 = "DELETE FROM prenotazioni where id_prenotazione = '" . $pren["id_prenotazione"] . "';";
                                $result4 = mysqli_query($connessione, $sql4);
                            }
                        }

                        $sql4 = "UPDATE stagioni_orari SET id_fascia = '" . $f[$i] . "' WHERE (giorno_settimana = '$i' and id_stagione = '$ids');";
                        $result4 = mysqli_query($connessione, $sql4);

                        if (!$result4) {
                            echo "ErrUpdtStgFscFailedUpdt";
                            exit(-2);
                        } else
                            $ritorno = true;
                    } else {
                        echo "ErrUpdtStgFscFailedSearchPren";
                        exit(-2);
                    }
                }
            }
        } else {
            echo "ErrUpdStgBadStgNRows";
            exit(-2);
        }

        return $ritorno;
    }
}
?>