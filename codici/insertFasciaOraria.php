<?php

	$nome = $_POST["nomeFascia"];
	
	$orari = array();
	for($i=0; $i < 6; $i++)
	{
		if(isset($_POST["orarioFase" . $i]))
			$orari[$i] = $_POST["orarioFase" . $i];
		else
			$orari[$i] = null;
	}
	
	// Connessione al DB
	
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";

	$connessione = mysqli_connect($host, $user, $pass);
	$db_selected=mysqli_select_db($connessione, $dbname);
	
	$sql = "SELECT MAX(id_fascia) As massimo FROM gestionefasceorarie;";
	$result = mysqli_query($connessione, $sql);
	if ($result)
	{
		$row = mysqli_fetch_array($result);
		$id = $row["massimo"] + 1;
	}
	else
		$id = 1;

	$sql = "INSERT INTO gestionefasceorarie (nome, id_fascia) VALUES ('" . $nome . "', '" . $id . "');";

	if (mysqli_query($connessione, $sql))
	{
		echo "La fascia è stata inserita correttamente<br>";
		
		$sql = "INSERT INTO fasceorarie (id_fascia, orario, fase) VALUES ";
		for($i=0; $i < 6; $i++)
		{
			if(sizeof($orari[$i]) > 0)
				for($j=0; $j < sizeof($orari[$i]); $j++)
					$sql .= "('" . $id . "', '" . $orari[$i][$j] . "', '" . $i . "'),";
		}		
		$sql = substr($sql, 0, strlen($sql) - 1) . ";";
		
		
		if (mysqli_query($connessione, $sql))
			echo "L'orario è stato inserito correttamente<br>";
		else
			echo "Errore: " . $sql . "<br>" . mysqli_error($connessione);

	}
	else
		echo "Errore: " . $sql . "<br>" . mysqli_error($connessione);
	mysqli_close($connessione);
	

?>