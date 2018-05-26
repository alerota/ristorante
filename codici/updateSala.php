<?php

	$nome = $_POST["nomeSala"];
	$n = $_POST["numeroPosti"];
	$id = $_POST["idSala"];
	
	// Connessione al DB

	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";

	$connessione = mysqli_connect($host, $user, $pass);
	$db_selected=mysqli_select_db($connessione, $dbname);
	
	$sql = "SELECT * FROM sale WHERE id_sala = " . $id . ";";
	$result = mysqli_query($connessione, $sql);
	$num = mysqli_num_rows($result);
	
	if($num == 1)
	{
		$row = mysqli_fetch_array($result);
		$oldNumber = $row["Numero_posti_prenotabili"];
		$oldName =$row["Nome_sala"];
		
		if($oldNumber <= $n)
		{
			$sql = "UPDATE sale SET Nome_sala = '" . $nome . "', Numero_posti_prenotabili = " . $n . " WHERE id_sala = " . $id . ";";
			$result2 = mysqli_query($connessione, $sql);
			
			if($result2)
				echo "Aggiornamento avvenuto con successo!";
			else
				echo "Aggiornamento fallito...";
		}
		else
		{
			$sql1 = "SELECT prenotazioni.giorno, sostegno.fase FROM `prenotazioni`
				inner join (select distinct orario, fase from fasceorarie) as sostegno 
				on prenotazioni.orario = sostegno.orario

				WHERE prenotazioni.id_sala = " . $id . " and chiusura = 0

				GROUP BY prenotazioni.giorno, sostegno.fase
				HAVING sum(num_partecipanti) > " . $n . ";";
				
			$result1 = mysqli_query($connessione, $sql1);
			
			if($result1)
			{
				$numResult1 = mysqli_num_rows($result1);
				$idDaCancellare = "(";
				
				for($i=0; $i < $numResult1; $i++)
				{
					$row1 = mysqli_fetch_array($result1);
					$sql2 = 'SELECT * FROM `prenotazioni`
						inner join (select distinct orario, fase from fasceorarie) as sostegno 
						on prenotazioni.orario = sostegno.orario

						WHERE prenotazioni.id_sala = ' . $id . ' and sostegno.fase = ' . $row1["fase"] . ' and prenotazioni.giorno = "' . $row1["giorno"] . '";';
					
					$result2 = mysqli_query($connessione, $sql2);
					
					if($result2)
					{
						$numResult2 = mysqli_num_rows($result2);
						
						$inserimento = "INSERT INTO prenotazionidarevisionare (id_prenotazione, cliente, tel, num_partecipanti, giorno, orario, id_sala, note_prenotazione)
							VALUES ";
						
						for($j=0; $j < $numResult2; $j++)
						{
							$row = mysqli_fetch_array($result2);
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
				if($idDaCancellare != "(")
				{
					$idDaCancellare = substr($idDaCancellare, 0, strlen($idDaCancellare) - 2) . ")";
					
					$sql3 = "DELETE FROM prenotazioni WHERE id_prenotazione IN " . $idDaCancellare . ";";
					
					$resultIntermedio = mysqli_query($connessione, $sql3);
				}
				
				$sql = "UPDATE sale SET Nome_sala = '" . $nome . "', Numero_posti_prenotabili = " . $n . " WHERE id_sala = " . $id . ";";
				$result2 = mysqli_query($connessione, $sql);
				
				if($result2)
					echo "Aggiornamento avvenuto con successo!";
				else
					echo "Aggiornamento fallito...";
					
				
			}
			
		}
	}
	else
		echo "Errore: conflitto di id";
	
	mysqli_close($connessione);
	echo "<script> window.location.href = '../sale.php'; </script>";
?>