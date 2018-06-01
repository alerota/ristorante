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

	$nome = gestioneEccezioneVirgolette($_POST["nomeSala"]);
	$n = $_POST["numeroPosti"];
	$id = $_POST["idSala"];
	
	$query = "SELECT * FROM sale WHERE id_sala = " . $id . ";";
    $result = $connessione->query($query);
    $num = $result->num_rows;
	
	if($num == 1) {
        $row = $result->fetch_assoc();

		$oldNumber = $row["Numero_posti_prenotabili"];
		$oldName =$row["Nome_sala"];
		
		if($oldNumber <= $n) {
			$query = "UPDATE sale SET Nome_sala = '" . $nome . "', Numero_posti_prenotabili = " . $n . " WHERE id_sala = " . $id . ";";
			$result2 = $connessione->query($query);
			
			if($result2)
				echo "Aggiornamento avvenuto con successo!";
			else
				echo "Aggiornamento fallito...";
		}
		else {
			$query1 = "SELECT prenotazioni.giorno, sostegno.fase FROM `prenotazioni`
				INNER JOIN (SELECT DISTINCT orario, fase FROM fasceorarie) AS sostegno 
				ON prenotazioni.orario = sostegno.orario

				WHERE prenotazioni.id_sala = " . $id . " AND chiusura = 0

				GROUP BY prenotazioni.giorno, sostegno.fase
				HAVING SUM(num_partecipanti) > " . $n . ";";
				
			$result1 = $connessione->query($query1);
			
			if($result1) {
				$numResult1 = $result1->num_rows;
				$idDaCancellare = "(";
				
				for($i=0; $i < $numResult1; $i++) {
                    $row1 = $result->fetch_assoc();
					$query2 = 'SELECT * FROM `prenotazioni`
						INNER JOIN (SELECT DISTINCT orario, fase FROM fasceorarie) AS sostegno 
						ON prenotazioni.orario = sostegno.orario

						WHERE prenotazioni.id_sala = ' . $id . ' AND sostegno.fase = ' . $row1["fase"] . ' AND prenotazioni.giorno = "' . $row1["giorno"] . '";';
					
					$result2 = $connessione->query($query2);
					
					if($result2) {
						$numResult2 = $result2->num_rows;
						
						$inserimento = "INSERT INTO prenotazionidarevisionare (id_prenotazione, cliente, tel, num_partecipanti, giorno, orario, id_sala, note_prenotazione)
							VALUES ";
						
						for($j=0; $j < $numResult2; $j++) {
							$row = $result2->fetch_assoc();

							$inserimento .= "(" . $row["id_prenotazione"] . ", '" . $row["cliente"] . "', '" . $row["tel"] . "', " . $row["num_partecipanti"] . ", '" . $row["giorno"] . "', '" . $row["orario"] . "', " . $row["id_sala"] . ", '" . $row["note_prenotazione"] . "')";
							$idDaCancellare .= $row["id_prenotazione"] . ", ";

							if($j + 1 < $numResult2)
								$inserimento .= ", ";
							else
								$inserimento .= ";";
						}

						// echo $inserimento . "<br>" . mysqli_errno($connessione) . " - " . mysqli_error($connessione);
						$resultIntermedio = mysqli_query($connessione, $inserimento);
						
						if($resultIntermedio)
							echo "Successo<br>";
						else
							echo "Errore<br>";
					}
				}
				if($idDaCancellare != "(") {
					$idDaCancellare = substr($idDaCancellare, 0, strlen($idDaCancellare) - 2) . ")";
					
					$query3 = "DELETE FROM prenotazioni WHERE id_prenotazione IN " . $idDaCancellare . ";";
					
					$resultIntermedio = $connessione->query($query3);
				}
				
				$query = "UPDATE sale SET Nome_sala = '" . $nome . "', Numero_posti_prenotabili = " . $n . " WHERE id_sala = " . $id . ";";
				$result2 = $connessione->query($query);
				
				if($result2)
					echo "Aggiornamento avvenuto con successo!";
				else
					echo "Aggiornamento fallito...";
					
				
			}
			
		}
	}
	else
		echo "Errore: conflitto di id";

    echo "<script> window.location.href = '../elenca/sale.php'; </script>";
	
	mysqli_close($connessione);
?>