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

	$nome = $_POST["nomeFascia"];
	
	$orari = array();
	for($i=0; $i < 6; $i++) {
		if(isset($_POST["orarioFase" . $i]))
			$orari[$i] = $_POST["orarioFase" . $i];
		else
			$orari[$i] = null;
	}
	
	$query = "SELECT MAX(id_fascia) As massimo FROM gestionefasceorarie";
    $result = $connessione->query($query);

	if ($result) {
        $row = $result->fetch_assoc();
		$id = $row["massimo"] + 1;
	}
	else
		$id = 1;

	$query = "INSERT INTO gestionefasceorarie (nome, id_fascia) VALUES ('" . $nome . "', '" . $id . "')";

	if ($connessione->query($query)) {
	    $query = "INSERT INTO fasceorarie (id_fascia, orario, fase) VALUES ";
		for($i=0; $i < 6; $i++)
		{
			if(sizeof($orari[$i]) > 0)
				for($j=0; $j < sizeof($orari[$i]); $j++)
					if($orari[$i][$j] != "")
						$query .= "('" . $id . "', '" . $orari[$i][$j] . "', '" . $i . "'),";
		}
        $query = substr($query, 0, strlen($query) - 1) . ";";
		
		
		if ($connessione->query($query))
            echo "<script> window.location.href = '../elenchi/fasce.php?messaggio=La fascia è stata inserita correttamente!';</script>";
		else
            echo "<script> window.location.href = '../elenchi/fasce.php?error=Errore nel inserimento della fascia!';</script>";

	}
	else
        echo "<script> window.location.href = '../elenchi/fasce.php?error=Errore nel inserimento della fascia!';</script>";

	mysqli_close($connessione);
?>