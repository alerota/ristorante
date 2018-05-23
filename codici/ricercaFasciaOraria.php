<head>   
        <!-- Bootstrap CSS --><!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
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
	$n = $_GET["numeroPartecipanti"];
	$faseScelta = $_GET["fase"];
	
	// echo $giornoSettimana;
	
	$sql = "SELECT * FROM Stagioni INNER JOIN
	Stagioni_orari on stagioni.id_stagione = stagioni_orari.id_stagione WHERE 
	((giorno_inizio <= '" . $data . 
	"' AND giorno_fine >= '" . $data . 
	"' AND giorno_settimana = " . $giornoSettimana . ") OR
	(giorno_inizio = '" . $data_supporto . "' AND giorno_fine = '" . $data_supporto . "'))
	ORDER BY priorita DESC, giorno_inizio DESC;";
	
	// echo $sql . "<br>";
	
	$result = mysqli_query($connessione, $sql);
	$num_row1 = mysqli_num_rows($result);

	if($num_row1 == 0)
		echo "Impossibile prenotare questa data";
	else
	{
		// Prendo il primo risultato
		
		$row1 = mysqli_fetch_array($result);
		$idFascia = $row1["id_fascia"];
		$stagione = $row1["id_stagione"];
		
		/* data, idFascia, stagione */
		
		// Ora che so la stagione e la fascia, indico (per ogni sala e per ogni fase)
		// quanti posti liberi ho
		
		// Ricerca 
		$sql = "select stagioni_sale.id_sala, tentativo.Nome_sala, tentativo.postiLiberi, tentativo.Numero_posti_prenotabili, tentativo.fase from stagioni_sale inner join 
			(select sale.id_sala, sale.Nome_sala, sale.Numero_posti_prenotabili - sum(prenotazioni.num_partecipanti) 
			as postiLiberi, sale.Numero_posti_prenotabili, fasceorarie.fase
			from sale 
			inner join prenotazioni on prenotazioni.id_sala = sale.id_sala
			inner join fasceorarie on fasceorarie.orario = prenotazioni.orario and fasceorarie.id_fascia = " . $idFascia . "
			where giorno = '" . $data . "' and chiusura = 0
			group by fasceorarie.fase, sale.id_sala
			having (sum(prenotazioni.num_partecipanti) + " . $n . " <= sale.Numero_posti_prenotabili)

			UNION

			select distinct sale.id_sala, sale.Nome_sala, sale.Numero_posti_prenotabili AS postiLiberi, 
			sale.Numero_posti_prenotabili, supporto.fase
			from sale
			inner join (select fasceorarie.fase from fasceorarie where fasceorarie.id_fascia = " . $idFascia . ") AS supporto
			left join (select prenotazioni.*, fasceorarie.fase from prenotazioni inner join fasceorarie
			on fasceorarie.orario = prenotazioni.orario where prenotazioni.giorno = '" . $data . "') As sostegno 
			on (sostegno.id_sala = sale.id_sala and sostegno.fase = supporto.fase)
			where sostegno.id_sala is null and " . $n . " <= sale.Numero_posti_prenotabili

		) as tentativo on tentativo.id_sala = stagioni_sale.id_sala and id_stagione = " . $stagione . "
		where fase = " . $faseScelta . "
		ORDER BY stagioni_sale.`id_sala` ASC, `fase` ASC";
		
		
		
		$result = mysqli_query($connessione, $sql);
		$saleLibereInGiornata = mysqli_num_rows($result);
		
		if($saleLibereInGiornata === false)
			$saleLibereInGiornata = 0;
		
		if($saleLibereInGiornata == 0)
			echo "Non sono disponibili sale nella data selezionata...";
		else
		{
			$fasiNomi = array("Colazione", "Brunch", "Pranzo", "Aperitivo", "Cena", "Serata");
			$finale = "";
			for($i=0; $i < $saleLibereInGiornata; $i++)
			{
				$row2 = mysqli_fetch_array($result);
				$idSala = $row2["id_sala"];
				$nome = $row2["Nome_sala"];
				$num = $row2["postiLiberi"];
				$fase = $row2["fase"];
				$sql2 = "select sostegno.orario, sum(aiuto.num_partecipanti), sostegno.Numero_posti_prenotabili from (
					select sale.id_sala, sale.Nome_sala, sale.Numero_posti_prenotabili, fasceorarie.orario from sale 
					inner join stagioni_sale on sale.id_sala = stagioni_sale.id_sala
					inner join fasceorarie
					where fasceorarie.id_fascia = " . $idFascia . " and stagioni_sale.id_stagione = " . $stagione . " 
					and sale.id_sala = " . $idSala . " and fasceorarie.fase = " . $fase . ") as sostegno
					left join (select * from prenotazioni where prenotazioni.giorno = '" . $data . "') as aiuto
					on aiuto.id_sala = sostegno.id_sala and sostegno.orario = aiuto.orario
					group by sostegno.orario
					having sum(aiuto.num_partecipanti) < 20 or sum(aiuto.num_partecipanti) is null";
				
				// echo $sql2 . "<br>";
				
				$resultOrariDisponibili = mysqli_query($connessione, $sql2);
				$num_orariDisponibili = mysqli_num_rows($resultOrariDisponibili);
				
				$risultato = "<label style='margin-top: 10px;'>" . $nome . " [" . $fasiNomi[$fase] . "]</label><br>";
				if(!$resultOrariDisponibili)
					$risultato .= "Non sono disponibili orari<hr>";
				else
				{
					$postiTot = 0;
					for($j=0; $j < $num_orariDisponibili; $j++)
					{
						$row3 = mysqli_fetch_array($resultOrariDisponibili);
						if($row3["sum(aiuto.num_partecipanti)"] == null)
							$posti = 0;
						else
							$posti = $row3["sum(aiuto.num_partecipanti)"];
						$risultato .= '<button onclick="fase3(\'' . $row3["orario"] . '\', \'' . $nome . '\')" class="btn btn-primary sceltaSala" type="button" >' . $row3["orario"] . '</button>';
						$postiTot += $posti;
					}
					$risultato .= "<br>";
				}
				$finale .= $risultato . "";
			}
			echo $finale;
		}
	}

	
	
?>





	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>