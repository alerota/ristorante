<?php
    
	function gestioneEccezioneVirgolette($testo)
	{
		while(strpos($testo, "\"") !== false)
			$testo = str_replace("\"", "``", $testo);
		while(strpos($testo, "'") !== false)
			$testo = str_replace("'", "`", $testo);
		return $testo;
	}

if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://localhost/ristorante/index.php";</script>';
    exit();
}
else {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ristorante";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }

    if ($_POST != null) {
        $user = gestioneEccezioneVirgolette($_POST['username']);
        $password = md5($_POST['password']);
        $query = "SELECT * FROM utenti WHERE username='$user'";
        $result = $connessione->query($query);

        if ($result->num_rows == 1)
            echo "<script> window.location.href= '../AggiuntaNuovoUtente.php?alert=Username gia esistente';</script>";
        else {
            $query2 = "INSERT INTO utenti(username, password) VALUES ('$user', '$password')";
            $result = $connessione->query($query2);
            if ($result)
                echo "<script> window.location.href= '../../elenchi/utenti.php?messaggio=Utente inserito correttamente!';</script>";
            else
                echo "<script> window.location.href= '../../elenchi/utenti.php?error=Errore nel inserimento!';</script>";
        }
    }

    mysqli_close($connessione);
}
?>