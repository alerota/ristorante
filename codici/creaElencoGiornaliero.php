<?php
	
	function creaFile($text, $today)
	{
		
		$nomeFile = "Prenotazioni" . $today . "-";
		$contatore = 0;
		while(file_exists("Documenti/" . $nomeFile . $contatore . ".txt"))
			$contatore++;
		$nomeFile .= $contatore . ".txt";
	
		$myfile = fopen("Documenti/" . $nomeFile, "w") or die("Non sono riuscito a creare il file!");
		
		fwrite($myfile, $text);
		fclose($myfile);
		return $nomeFile;
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
	
	if(isset($_GET["data"]) && isset($_GET["t"]))
	{
		$data = $_GET["data"];
		
		$sql = "select * from prenotazioni inner join sale on (prenotazioni.id_sala = sale.id_sala) where giorno = '" . $data . "' order by cliente;";
		
		$result = mysqli_query($connessione, $sql);
		
		if($result && mysqli_num_rows($result) > 0)
		{
			$tipo = $_GET["t"];
			$testo = "";
			while($row = mysqli_fetch_assoc($result))
			{
				$testo .= "Nome: " . $row["cliente"] . ",   Telefono: " . $row["tel"] . ",   Numero di partecipanti: " . $row["num_partecipanti"] . "\n";
				$testo .= "Giorno: " . date("d-m-Y", strtotime($row["giorno"])) . ",   Orario: " . $row["orario"] . ",   Sala: " . $row["Nome_sala"] . "\n";
				$testo .= "Note: " . $row["note"] . "\n-----------------------------------------------\n";
			}
			
			if($tipo == "file")
			{
				$nomeFile = creaFile($testo, $data);
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename=Documenti/'.basename($nomeFile));
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize("Documenti/" . $nomeFile));
				
				header('location: ../Impostazioni.php?messaggio=http://localhost/ristorante/codici/Documenti/' . $nomeFile);
			}
			else if($tipo == "mail")
			{
				// Multiple recipients
				$to = 'davidepizzoli1234@gmail.com'; // note the comma

				// Subject
				$subject = 'Prenotazioni di oggi';

				// Message
				$message = '
				<html>
				<head>
				  <title>Prenotazioni di oggi</title>
				</head>
				<body>
				  <p>Eccoti l\'elenco delle prenotazioni di oggi</p>' . str_replace("\n", "<br>", $testo) . '
				</body>
				</html>
				';

				// To send HTML mail, the Content-type header must be set
				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-type: text/html; charset=iso-8859-1';

				// Additional headers
				$headers[] = 'To: Davide <davidepizzoli1234@gmail.com>';
				$headers[] = 'From: RestIT <davidepizzoli1234@gmail.com>';

				// Mail it
				mail($to, $subject, $message, implode("\r\n", $headers));
			}
		}
		else
			echo "Nessuna prenotazione oggi...";
	}
	mysqli_close($connessione);
?>