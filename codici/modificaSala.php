<?php

$nome = $_POST["nomeSala"];
$n = $_POST["numeroPosti"];

if($n < 0)
    header("Location: sale.php?alert=Numero posti minori di zero.");
else {

    //gestire prenotazioni-sale

    // Connessione al DB

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ristorante";

    $connessione = mysqli_connect($host, $user, $pass);
    $db_selected = mysqli_select_db($connessione, $dbname);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE sale SET Nome_sala='$nome' WHERE id_sala='$id'";

        if (mysqli_query($connessione, $sql))
            header("Location: ../sale.php?messaggio=La sala è stata aggiornata correttamente");
        else
            header("Location: ../sale.php?alert=Errore nella modifica");

        mysqli_close($connessione);
    }
    else
        header("Location: ../sale.php?alert=Errore nella modifica");


}
    ?>
