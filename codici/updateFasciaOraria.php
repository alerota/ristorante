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
            if(isset($_POST["orario".$i]))
                $orari[$i] = $_POST["orario" . $i];
            else {
                $orari[$i] = null;
            }

        }
        print_r($orari);

        $query = "SELECT * FROM fasceorarie WHERE id_fascia = '$idFascia'";
        $result = $connessione->query($query);
        $num_rows = $result->num_rows;

        if($num_rows != 0) {
            $orariDB = $result->fetch_assoc();
            $trovato = false;

            for($i = 0; $i < $num_rows; $i++) {
                for($j = 0; $j < 6 && !$trovato; $j++)
                    if($orari[$j] != null)
                        if($orari[$j] == $orariDB['orario'])
                            $trovato = true;
                

            }
        }
        else {
            echo "errore";
        }
    }
    else {
        mysqli_close($connessione);
        echo "<script> window.location.href = '../forms/AggiuntaNuovaFasciaOraria.php?alert=Errore nel caricamento della fascia'</script>";
    }
?>