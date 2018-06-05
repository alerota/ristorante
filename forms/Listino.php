<?php

if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://localhost/ristorante/index.php";</script>';
    exit();
}
else {
    if (isset($_GET["msg"])) {
        $idImportante = $_GET["msg"];

        // Connessione al DB
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "ristorante";

        $connessione = new mysqli($host, $user, $pass, $dbname);

        if ($connessione->connect_errno) {
            echo "Errore in connessione al DBMS: " . $connessione->error;
        }

        if (isset($_GET["t"])) {
            if ($_GET["t"] == "r")
                $query = "SELECT * FROM prenotazionidarevisionare LEFT JOIN sale on prenotazionidarevisionare.id_sala = sale.id_sala WHERE id_prenotazione = $idImportante;";
            else if ($_GET["t"] == "n")
                $query = "SELECT * FROM prenotazioni LEFT JOIN sale on prenotazioni.id_sala = sale.id_sala WHERE id_prenotazione = $idImportante;";
            else {
                echo "<br>ErrBadTypeEditOrder";
                exit(-2);
            }

            $result = $connessione->query($query);
            $num = $result->num_rows;

            if ($num == 1) {
                $row = $result->fetch_assoc();

                $nome1 = $row["cliente"];
                $tel1 = $row["tel"];
                $note1 = $row["note_prenotazione"];
                $partecipanti1 = $row["num_partecipanti"];
                if (isset($row["Nome_sala"]))
                    $sala1 = $row["Nome_sala"];
                else
                    $sala1 = "x";
                $giorno1 = date("d-m-Y", strtotime($row["giorno"]));
                $orario1 = $row["orario"];

                $connessione->close();
            } else {
                echo "<br>ErrMssMtchOrder";
                exit(-2);
            }
        } else {
            echo "<br>ErrMssTypeEditOrder";
            exit(-2);
        }
    } else
        exit(-1);
    ?>
    <br>
    <h1>Dettagli</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">Nome: <strong><?php echo $nome1; ?></strong></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12">Tel: <strong><?php echo $tel1; ?></strong></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12">Num. partecipanti: <strong><?php echo $partecipanti1; ?></strong></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12">Sala: <strong><?php echo $sala1; ?></strong></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12">Giorno: <strong><?php echo $giorno1; ?></strong></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12">Orario: <strong><?php echo $orario1; ?></strong></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12">Note<br><strong><?php echo $note1; ?></div>
    </div>
    <hr>

    <?php
}
?>





