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
    $pass = $_POST["password"];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = "SELECT * FROM utenti WHERE id = '$id'";
        $result = $connessione->query($query);

        if ($result) {
            $row = $result->fetch_assoc();

            if (strcmp($row["password"], $pass) != 0)
                $pass = md5($pass);

            $query = "UPDATE utenti SET username='$username', password='$pass' WHERE id='$id'";

            if ($connessione->query($query))
                echo "<script> window.location.href = '../../elenchi/utenti.php?messaggio=Modifica effuttuata correttamente!';</script>";
            else
                echo "<script> window.location.href = '../../elenchi/utenti.php?alert=Errore nella modifica!';</script>";

        }

    } else
        echo "<script> window.location.href = '../../elenchi/utenti.php?alert=Errore nella modifica!';</script>";

    mysqli_close($connessione);
}
?>
