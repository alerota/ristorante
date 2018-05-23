<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ristorante";

$connessione = mysqli_connect($host, $user, $pass);
$db_selected = mysqli_select_db($connessione, $dbname);

if ($connessione->connect_errno) {
    echo "Errore in connessione al DBMS: " . $connessione->error;
}

if($_POST != null) {
    $user = $_POST['username'];
    $password = md5($_POST['password']);
    $query = "SELECT * FROM utenti WHERE username='$user'";
    $result = $connessione->query($query);

    if($result->num_rows == 1)
        echo "<script> window.location.href= '../AggiuntaNuovoUtente.php?alert=Username gia esistente';</script>";
    else {
        $query2 = "INSERT INTO utenti(username, password) VALUES ('$user', '$password')";
        $result = $connessione->query($query2);
        if($result)
            echo "<script> window.location.href= '../utenti.php?messaggio=Utente inserito con successo!';</script>";
        else
            echo "<script> window.location.href= '../utenti.php?alert=Errore nel inserimento!';</script>";
    }
}