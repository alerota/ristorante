<html>
	<?php

		// Connessione al DB

		$host = "localhost";
		$user = "root";
		$pass = "";
		$dbname = "ristorante";

		$connessione = mysqli_connect($host, $user, $pass);
		$db_selected=mysqli_select_db($connessione, $dbname);

	?>
	<head>   
        <!-- Bootstrap CSS --><!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
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
		
		<div class="container">
		<hr>
			<form method="POST" action="codici/insertStagione.php" id="formAddStagione">
				<div class="row">
					<div class="col-md-3">
						<fieldset>
							<legend>Orari settimanali</legend>
							<?php
							
								$sql = "select * from gestionefasceorarie;";

								$result = mysqli_query($connessione, $sql);
								$num_result = mysqli_num_rows($result);

								$select = '<div class="form-group"><label for="selNumeroGiornoSettimana">NomeGiornoSettimana</label><select class="form-control" id="selNumeroGiornoSettimana" name="giorni[]">';

								for($i=0; $i < $num_result; $i++)
								{
									$row = mysqli_fetch_array($result);
									$select .= '<option value="' . $row["id_fascia"] . '">' . $row["nome"] . '</option>';
								}
								$select .= '</select></div>';
								$giorniSettimana = ["Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica"];

								for($i=0; $i < 7; $i++)
									echo str_replace("NomeGiornoSettimana", $giorniSettimana[$i], str_replace("NumeroGiornoSettimana", $i, $select));
									

							?>
						</fieldset>
					</div>
					<div class="col-md-6">
						<br>
						<div class="alert alert-info">
							Benvenuto, questa è la pagina per l'inserimento di una nuova stagione.
						</div>
						<div class="alert alert-info">
							Alla tua sinistra puoi selezionare una fascia oraria differente per ogni
							giorno della settimana. Alla tua destra puoi scegliere il nome della
							stagione, la sua priorità rispetto ad altre stagioni eventualmente in
							conflitto e le sale.
						</div>
						<div class="alert alert-warning">
							Le sale che non saranno selezionate saranno considerate chiuse in questa
							stagione.
						</div>
						<button onclick="document.getElementById('formAddStagione').submit();" class="btn btn-primary center-block" type="button" style="width: 50%; ">Aggiungi</button>
						
					</div>
					<div class="col-md-3">
						<fieldset>
							<legend>Dettagli</legend>
							<div class="form-group">
								<a data-toggle="tooltip" title="Cerca un nome efficace e intuitivo (Ex. Stagione estiva)">
									<label>Nome identificativo</label>
								</a>
								<label></label>
								<input type="text" name="nomeStagione" class="form-control" placeholder="Nome">
								<span class="help-block"></span>
								
								<a data-toggle="tooltip" title="0 = minimo, 10 = massimo">
									<label>Priorità</label>
								</a>
								<input type="number" name="prioritaStagione" class="form-control" placeholder="priorita">
								<span class="help-block"></span>
								
								<label>Data di inizio</label>
								<input type="date" name="inizioStagione" class="form-control">
								<span class="help-block"></span>
								
								<label>Data di fine</label>
								<input type="date" name="fineStagione" class="form-control">
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
									echo '<div class="checkbox"><label><input type="checkbox" name="sala[]" value="' . $row["id_sala"] . '" checked>' . $row["Nome_sala"] . '</label></div>';
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
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>