<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ristorante";

$connessione = new mysqli($host, $user, $pass, $dbname);

if ($connessione->connect_errno) 
    echo "Errore in connessione al DBMS: " . $connessione->error;

if($_GET != null && isset($_GET["id"]) && isset($_GET["a"]) && isset($_GET["p"]))
{
	$id = $_GET["id"];
	$valore = $_GET["p"];
	$a = $_GET["a"];
	if($valore == 0)
		$antiValore = 1;
	else
		$antiValore = 0;
	
	if($a == "a")
	{
		if($valore == 1)
			$sql = "UPDATE prenotazioni SET arrivo = $valore, scadenza = $antiValore where id_prenotazione = '$id';";
		else
			$sql = "UPDATE prenotazioni SET arrivo = $valore where id_prenotazione = '$id';";
	}
	else if($a == "s")
	{
		if($valore == 1)
			$sql = "UPDATE prenotazioni SET arrivo = $antiValore, scadenza = $valore where id_prenotazione = '$id';";
		else
			$sql = "UPDATE prenotazioni SET scadenza = $valore where id_prenotazione = '$id';";
	}
	else if($a == "c")
		$sql = "UPDATE prenotazioni SET chiusura = $valore where id_prenotazione = $id;";
	else
	{
		echo "Parametro action non settato correttamente";
		exit(-2);
	}
	$result = $connessione->query($sql);
	
	// echo mysqli_errno($connessione) . " - " . mysqli_error($connessione);
	
	$today = date("Y-m-d");
	echo "<script> window.location.href = '../elenchi/prenotazioni.php?date=" . $today . "'; </script>";
	
}
else
	echo "Valori mancanti";

?>