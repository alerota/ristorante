<?php
    
	function gestioneEccezioneVirgolette($testo)
	{
		while(strpos($testo, "\"") !== false)
			$testo = str_replace("\"", "``", $testo);
		while(strpos($testo, "'") !== false)
			$testo = str_replace("'", "`", $testo);
		return $testo;
	}
	
    // Connessione al DB
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ristorante";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }

    $username = gestioneEccezioneVirgolette($_POST["username"]);
    $password = md5($_POST["password"]);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "UPDATE utenti SET username='$username', password='$password' WHERE id='$id'";

        if ($connessione->query($query))
            echo "<script> window.location.href = '../../elenchi/utenti.php';</script>";
        else
            echo "<script> window.location.href = '../../elenchi/utenti.php';</script>";
    }
    else
        echo "<script> window.location.href = '../../elenchi/utenti.php';</script>";

    mysqli_close($connessione);
?>
