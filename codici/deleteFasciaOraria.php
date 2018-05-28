<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "ristorante";

	$connessione = new mysqli($host, $user, $pass, $dbname);

	if ($connessione->connect_errno) {
		echo "Errore in connessione al DBMS: " . $connessione->error;
	}
		
	if(isset($_GET['id'])) {
		$idFascia = $_GET['id'];
		
		$query = "SELECT * FROM stagioni_orari NATURAL JOIN stagioni WHERE id_fascia='$idFascia'";

		$result = $connessione->query($query);
		$numrows = $result->num_rows;

		if ($numrows != 0) {
			$s = "";
			while ($row = $result->fetch_assoc()) {
				$s .= $row['nome_stagione'];
			}
			echo "<script> window.location.href = '../elenchi/fasce.php?alert=Fascia usata nelle stagioni '" .$s. "'; </script>";
		}
		else {
			$query = "DELETE FROM fasceorarie WHERE id_fascia = '$idFascia'"; 
			$result = $connessione->query($query);
			$query = "DELETE FROM gestionefasceorarie WHERE id_fascia = '$idFascia'"; 
			$result = $connessione->query($query);
			
			echo "<script> window.location.href = '../elenchi/fasce.php?amessaggi=Fascia oraria cancellata correttamente!'; </script>";
		}
	}
	
	mysqli_close($connessione);
	

?>