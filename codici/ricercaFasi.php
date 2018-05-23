<?php
	
	// Connessione DB

	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";
	
	$connessione = mysqli_connect($host, $user, $pass);
	$db_selected=mysqli_select_db($connessione, $dbname);
	
	$data = $_GET["date"];
	$giornoSettimana = date('N', strtotime($data)) - 1;
	$anno = substr($data, 0, 4);
	$data_supporto = "x" . substr($data, 4);

	// echo $giornoSettimana;
	
	$sql = "SELECT * FROM Stagioni INNER JOIN
	Stagioni_orari on stagioni.id_stagione = stagioni_orari.id_stagione WHERE 
	((giorno_inizio <= '" . $data . 
	"' AND giorno_fine >= '" . $data . 
	"' AND giorno_settimana = " . $giornoSettimana . ") OR
	(giorno_inizio = '" . $data_supporto . "' AND giorno_fine = '" . $data_supporto . "'))
	ORDER BY priorita DESC, giorno_inizio DESC;";
	
	$result = mysqli_query($connessione, $sql);
	$num_row1 = mysqli_num_rows($result);

	if($num_row1 == 0)
		echo "<p style='height: 34px; line-height: 34px;'>Nessuna fase disponibile.</p>";
	else
	{
		// Prendo il primo risultato
		
		$row1 = mysqli_fetch_array($result);
		$idFascia = $row1["id_fascia"];
		
		// Ricerca 
		$sql = "select distinct fase from fasceorarie where id_fascia = " . $idFascia . ";";
		
		$result = mysqli_query($connessione, $sql);
		$numFasi = mysqli_num_rows($result);
		
		if($numFasi == 0)
			echo "<p style='height: 34px; line-height: 34px;'>Nessuna fase disponibile.</p>";
		else
		{
			$fasiNomi = array("Colazione", "Brunch", "Pranzo", "Aperitivo", "Cena", "Serata");
			$finale = '<select class="form-control" id="fase" name="fase">';
			for($i=0; $i < $numFasi; $i++)
			{
				$row2 = mysqli_fetch_array($result);
				
				$finale .= "<option value='" . $row2["fase"] . "'>" . $fasiNomi[$row2["fase"]] . "</option>";
			}
			echo $finale . "</select>";
		}
	}

	
	
?>





	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>