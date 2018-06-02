<html>
	<?php

		// Connessione al DB

		$host = "localhost";
		$user = "root";
		$pass = "";
		$dbname = "ristorante";

		$connessione = mysqli_connect($host, $user, $pass);
		$db_selected=mysqli_select_db($connessione, $dbname);

		
		if($_GET != null)
		{
			$idImportante = $_GET["id"];
			$sql = "select * from stagioni where id_stagione = " . $idImportante . ";";

			$result = mysqli_query($connessione, $sql);
			
			$num_result = mysqli_num_rows($result);
			
			if($num_result == 1)
			{
				$row = mysqli_fetch_array($result);
				
				if($row["giorno_inizio"] == $row["giorno_fine"])
				{
					$name = $row["nome_stagione"];
					$start = $row["giorno_inizio"];
					$realDate = date("Y") . substr($start, strpos($start, "-"));
					$priority = $row["priorita"];
					
					$sql = "select * from stagioni_sale where id_stagione = " . $idImportante . ";";
					
					$result = mysqli_query($connessione, $sql);
					
					$num_result = mysqli_num_rows($result);
					
					$salePredisposte = array();
					for($i=0; $i < $num_result; $i++)
					{
						$row = mysqli_fetch_array($result);
						array_push($salePredisposte, $row["id_sala"]);
					}
					
					$sql = "select * from stagioni_orari where id_stagione = " . $idImportante . ";";
					
					$result = mysqli_query($connessione, $sql);
					
					$num_result = mysqli_num_rows($result);
					
					if($num_result == 7)
					{
						$row = mysqli_fetch_array($result);
						$orariScelti = $row["id_fascia"];
					}
					else
						echo "<script>alert('Fase 3: Problemi durante il caricamento della giornata, chiedere assistenza...');</script>";
				}
				else
					echo "<script>alert('Fase 2: Problemi durante il caricamento della giornata, chiedere assistenza...');</script>";
				
			}
			else
				echo "<script>alert('Fase 1: Problemi durante il caricamento della giornata, chiedere assistenza...');</script>";
		}

    include '../menu.php';
	?>
	<head>   
        
        <style>
            body {
                background-color: white;
            }
        </style>
        
		<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
		
		
		</script>
		
	</head>
	<body style="font-family: Arial;">
    <h1 class="card-title text-center"><?php if($_GET != null) echo "Modifica giorno speciale: ".$name; else echo "Aggiungi nuovo giorno speciale";?></h1>
		<div class="container">

		    <hr>
			<form method="POST" action="../codici/insert/insertGiornoSpeciale.php" id="insertGS">
				<div class="row">
					<div class="col-md-3">
						<fieldset>
							<legend>Orario</legend>
							<?php
							
								$sql = "select * from gestionefasceorarie;";

								$result = mysqli_query($connessione, $sql);
								$num_result = mysqli_num_rows($result);

								$select = '<div class="form-group"><label for="sel0">Seleziona l\'orario</label><select class="form-control" id="sel0" name="giorno0">';

								for($i=0; $i < $num_result; $i++)
								{
									$row = mysqli_fetch_array($result);
									$select .= '<option value="' . $row["id_fascia"] . '">' . $row["nome"] . '</option>';
								}
								$select .= '</select></div>';
								echo $select;
								if(isset($orariScelti))
									echo "<script> document.getElementById('sel0').value = " . $orariScelti . ";</script>";
							?>
							<div class="checkbox">
								<label>
									<input type="radio" name="ripetizioneGiorno" value="1"
									<?php if($_GET == null || (isset($start) && (strpos($start, "x") == 0)))
										echo "checked";
									?>
									>Ripeti ogni anno
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="radio" name="ripetizioneGiorno" value="0"
									<?php if($_GET != null && (isset($start) && (strpos($start, "x") === false)))
										echo "checked";
									?>
									>Non ripetere ogni anno
								</label>
							</div>
									
						</fieldset>
						<hr>
						<style>
						.infoBoxSpecial { min-height: 30px; line-height: 30px; transition-duration: 0.2s; padding: 0px 15px; width: 100%; border: 1px solid #CCCCCC; border-radius: 15px; margin: auto;margin-bottom: 10px; }
						.infoBoxSpecial:hover { background-color: #EEEEEE; }
						</style>
						<fieldset>
							<legend>Le tue giornate speciali</legend>
							<?php
								
								function getRealDate($a)
								{
									$c = explode("-", $a);
									$b = $c[2] . "-" . $c[1] . "-" . $c[0];
									return $b;
								}
								
								$sql = "select * from stagioni where giorno_inizio = giorno_fine;";

								$result = mysqli_query($connessione, $sql);
								$num_result = mysqli_num_rows($result);

								for($i=0; $i < $num_result; $i++)
								{
									$row = mysqli_fetch_array($result);
									echo '<div class="row infoBoxSpecial">' . $row["nome_stagione"] . ' [ ' . getRealDate($row["giorno_inizio"]) . ' ]</div>';
								}
								if($i == 0)
									echo "Non hai ancora inserito giornate speciali";
								
							?>
									
						</fieldset>
						
					</div>
					<div class="col-md-6">
						<br>
						<div class="alert alert-info">
							Benvenuto, questa è la pagina per l'inserimento di un giorno speciale.
						</div>
						<div class="alert alert-info">
							Alla tua sinistra puoi selezionare una fascia oraria per la giornata. 
							Alla tua destra puoi scegliere il nome della giornata e le sale.
							Attento a non aggiungere una giornata speciale che vada in conflitto
							con altre giornate speciali!
						</div>
						<div class="alert alert-warning">
							Le sale che non saranno selezionate saranno considerate chiuse in questa
							stagione.
						</div>
						<button onclick="document.getElementById('insertGS').submit();" class="btn btn-primary center-block" type="button" style="width: 50%; ">
						<?php if($_GET != null) echo "Aggiorna"; else echo "Aggiungi"; ?>
						</button>
						
					</div>
					<div class="col-md-3">
						<fieldset>
							<legend>Dettagli</legend>
							<div class="form-group">
								<a data-toggle="tooltip" title="Cerca un nome efficace e intuitivo (Ex. Natale)">
									<label>Nome identificativo</label>
								</a>
								<label></label>
								<input type="text" name="nomeGiorno" class="form-control"
								<?php if(isset($name)) echo "value='" . $name . "'"; ?>
								placeholder="Nome">
								<span class="help-block"></span>
								
								<label>Data</label>
								<input type="date" name="giornata" class="form-control"
								<?php if(isset($realDate)) echo "value='" . $realDate . "'"; ?>>
								
								<span class="help-block"></span>
							</div>
						</fieldset>
						<hr>
						<fieldset>
							<legend>Scelta Sale</legend>
							<?php
							
								$sql = "select * from sale;";

								$result = mysqli_query($connessione, $sql);
								$num_result = mysqli_num_rows($result);
								
								
								for($i=0; $i < $num_result; $i++)
								{
									$row = mysqli_fetch_array($result);
									echo '<div class="checkbox"><label><input type="checkbox" name="sala[]" class="sceltaSale" value="' . $row["id_sala"] . '" ';
									
									if(!isset($salePredisposte) || in_array($row["id_sala"], $salePredisposte))
										echo 'checked';
									echo '>' . $row["Nome_sala"] . '</label></div>';
									// echo "<br>";
								}
							?>
						</fieldset>
					</div>
				</div>
			</form>
			<hr>
		</div>
	</body>
</html>