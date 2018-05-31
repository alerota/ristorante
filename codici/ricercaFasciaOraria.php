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
	
	$data = $_GET["date"];
	$giornoSettimana = date('N', strtotime($data)) - 1;
	$anno = substr($data, 0, 4);
	$data_supporto = "x" . substr($data, 4);
	$n = $_GET["numeroPartecipanti"];
	$faseScelta = $_GET["fase"];
	
	// echo $giornoSettimana;
	
	$query = "SELECT * FROM Stagioni INNER JOIN
	Stagioni_orari on stagioni.id_stagione = stagioni_orari.id_stagione WHERE 
	((giorno_inizio <= '" . $data . 
	"' AND giorno_fine >= '" . $data . 
	"' AND giorno_settimana = " . $giornoSettimana . ") OR
	(giorno_inizio = '" . $data_supporto . "' AND giorno_fine = '" . $data_supporto . "'))
	ORDER BY priorita DESC, giorno_inizio DESC;";
	
	// echo $sql . "<br>";
	
	$result = $connessione->query($query);
    $num_row1 = $result->num_rows;

	if($num_row1 == 0)
		echo "Impossibile prenotare questa data";
	else {
		// Prendo il primo risultato
        $row1 = $result->fetch_assoc();

		$idFascia = $row1["id_fascia"];
		$stagione = $row1["id_stagione"];
		
		/* data, idFascia, stagione */
		// Ora che so la stagione e la fascia, indico (per ogni sala e per ogni fase)
		// quanti posti liberi ho
		
		// Ricerca 
		$query = "select stagioni_sale.id_sala, tentativo.Nome_sala, tentativo.postiLiberi, tentativo.Numero_posti_prenotabili, tentativo.fase from stagioni_sale inner join 
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
		
		$ids = array();

        $result = $connessione->query($query);
        $saleLibereInGiornata = $result->num_rows;
		
		if($saleLibereInGiornata === false)
			$saleLibereInGiornata = 0;
		
		if($saleLibereInGiornata == 0)
			$finale = "Non sono disponibili sale nella data selezionata...";
		else {
			$fasiNomi = array("Colazione", "Brunch", "Pranzo", "Aperitivo", "Cena", "Serata");
			$finale = "";

			for($i=0; $i < $saleLibereInGiornata; $i++) {
                $row2 = $result->fetch_assoc();

				$idSala = $row2["id_sala"];
				$nome = $row2["Nome_sala"];
				$num = $row2["postiLiberi"];
				$fase = $row2["fase"];

                $query2 = "select sostegno.orario, sum(aiuto.num_partecipanti), sostegno.Numero_posti_prenotabili from (
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
				
				$resultOrariDisponibili = $connessione->query($query2);
				$num_orariDisponibili = $resultOrariDisponibili->num_rows;
				
				$risultato = "<label style='margin-top: 10px;'>" . $nome . " [" . $fasiNomi[$fase] . "]</label><br>";

				if(!$resultOrariDisponibili)
					$risultato .= "Non sono disponibili orari<hr>";
				else {
					$postiTot = 0;

					for($j=0; $j < $num_orariDisponibili; $j++) {
						$row3 = $resultOrariDisponibili->fetch_assoc();
						if($row3["sum(aiuto.num_partecipanti)"] == null)
							$posti = 0;
						else
							$posti = $row3["sum(aiuto.num_partecipanti)"];

						$risultato .= '<button id="' . $row3["orario"] . $idSala . '" onclick="fase3(\'' . $row3["orario"] . '\', \'' . $idSala . '\')" class="btn btn-primary sceltaSala" type="button" >' . $row3["orario"] . '</button>';
						$postiTot += $posti;
					}
					$risultato .= "<br>";
				}
				array_push($ids, $idSala);
						
				$finale .= $risultato;
			}


			// Adesso filtro gli orari per non avere troppe persone nello stesso momento
			$query = "select sum(num_partecipanti) as totale, orario from prenotazioni where giorno = '" . $data . "' and chiusura = 0
			group by(orario) having totale > 30;";

			$result = $connessione->query($query);
			$num_eccessi = $result->num_rows;
			
			// array ids contiene gli id delle sale
			$idsCount = sizeof($ids);
			
			for($i=0; $i < $num_eccessi; $i++) {
				$rowE = $result->fetch_assoc();
				for($j=0; $j < $idsCount; $j++) {
					$sostegno = 'id="' . $rowE["orario"] . $ids[$j] . '"';
					if(strpos($finale, $rowE["orario"] . $ids[$j]) != -1)
						$finale = str_replace($sostegno, 'style="display: none;"', $finale);
				}
			}
		}
			
		if(isset($_COOKIE["login"]))
			$finale .= '<hr><button onclick="ricercaSicura();" class="btn btn-danger" type="button" >
				Prenotazione sicura
			</button>';
		echo $finale;
	}

    mysqli_close($connessione);
?>