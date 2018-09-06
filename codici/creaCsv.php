<?php
	
    function creaFile($text)
    {
        $nomeFile = "CsvDaScaricare-";
        $contatore = 0;
        while (file_exists("Documenti/" . $nomeFile . $contatore . ".txt"))
            $contatore++;
        $nomeFile .= $contatore . ".txt";

        $myfile = fopen("Documenti/" . $nomeFile, "w") or die("Non sono riuscito a creare il file!");

        fwrite($myfile, $text);
        fclose($myfile);
        return $nomeFile;
    }

if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://prenotazioni.ristorante-almolo13.com/index.php";</script>';
    exit();
}
else {
    // Connessione al DB
    $host = "localhost";
    $user = "ristoran_pren";
    $pass = "szc[yPA-hIhB";
    $dbname = "ristoran_prenotazioni";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }

    if (isset($_GET["a"]) && isset($_GET["t"])) {
        // a = m -> scarica e mantieni
        // a = c -> scarica e cancella

        $a = $_GET["a"];

        $sql = "select * from storico order by nome_cliente;";

        $result = mysqli_query($connessione, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $tipo = $_GET["t"];
            $testo = "";
            while ($row = mysqli_fetch_row($result))
                $testo .= $row[1] . "|" . $row[2] . "\n";

            if ($a == "c") {
                $sql = "truncate table storico;";

                $result = mysqli_query($connessione, $sql);

                if (!$result)
                    echo "Errore nella cancellazione dei record...";
            }

            if ($tipo == "file") {
                $nomeFile = creaFile($testo);
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=Documenti/' . basename($nomeFile));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize("Documenti/" . $nomeFile));
                readfile("Documenti/" . $nomeFile);
                header('location: ../Impostazioni.php?messaggio=http://prenotazioni.ristorante-almolo13.com/codici/Documenti/' . $nomeFile);
            } else if ($tipo == "mail") {
                // Multiple recipients
                $to = 'davidepizzoli1234@gmail.com'; // note the comma

                // Subject
                $subject = 'Csv Storico';

                // Message
                $message = '
				<html>
				<head>
				  <title>Csv Storico</title>
				</head>
				<body>
				  <p>Eccoti l\'elenco dello storico in formato Csv</p>' . str_replace("\n", "<br>", $testo) . '
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
				echo "<script>window.location.href = '../Impostazioni.php?messaggio=Email inviata con successo!'; </script>";
            }
        } else
            echo "Nessun record nello storico...";
    }
    mysqli_close($connessione);
}
?>