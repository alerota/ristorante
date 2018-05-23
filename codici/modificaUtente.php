<?php

$username = $_POST["username"];
$password = md5($_POST["password"]);


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
    $sql = "UPDATE utenti SET username='$username', password='$password' WHERE id='$id'";

    if (mysqli_query($connessione, $sql))
        header("Location: ../utenti.php?messaggio=L'utente è stato aggiornato correttamente");
    else
        header("Location: ../utenti.php?alert=Errore nella modifica");

    mysqli_close($connessione);
}
else
    header("Location: ../utenti.php?alert=Errore nella modifica");



?>
