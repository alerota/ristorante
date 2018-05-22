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
			$sql = "select * from sale where id_sala = " . $idImportante . ";";

			$result = mysqli_query($connessione, $sql);
			
			$num_result = mysqli_num_rows($result);
			
			if($num_result == 1)
			{
				$row = mysqli_fetch_array($result);
				$name = $row["Nome_sala"];
				$number = $row["Numero_posti_prenotabili"];
			}
			else
				echo "<script>alert('Problemi durante il caricamento della sala, chiedere assistenza...');</script>";
		}
	?>
	<head>   
        <!-- Bootstrap CSS --><!-- Latest compiled and minified CSS -->
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
			<form method="POST" action="codici/insertSala.php" id="insertSL">
				<div class="row">
					<div class="col-md-3">
						<form method="POST" id="insertSL" action="codici/insertNuovaSala.php">
							<fieldset>
								<legend>Dettagli nuova sala</legend>
								<div class="form-group">
									<a data-toggle="tooltip" title="Cerca un nome efficace e intuitivo (Ex. Terrazza esterna)">
										<label>Nome identificativo</label>
									</a>
									<label></label>
									<input type="text" name="nomeSala" class="form-control" 
									<?php if(isset($name)) echo "value='" . $name . "'"; ?>
									placeholder="Nome">
									<span class="help-block"></span>
									
									<a data-toggle="tooltip" title="Fai attenzione! Questo numero rimane fissato ogni volta che usi questa sala">
										<label>Numero di posti</label>
									</a>
									<label></label>
									<input type="number" name="numeroPosti" class="form-control" 
									<?php if(isset($number)) echo "value='" . $number . "'"; ?>
									placeholder="Numero">
									<span class="help-block"></span>
								</div>
							</fieldset>
							<button onclick="document.getElementById('insertSL').submit();" class="btn btn-primary center-block" type="button" style="width: 100%; ">
							<?php if($_GET != null) echo "Aggiorna"; else echo "Aggiungi"; ?>
							</button>
						</form>
						<br>
						<style>
						.infoBoxSpecial { min-height: 30px; line-height: 30px; transition-duration: 0.2s; padding: 0px 15px; width: 100%; border: 1px solid #CCCCCC; border-radius: 15px; margin: auto;margin-bottom: 10px; }
						.infoBoxSpecial:hover { background-color: #EEEEEE; }
						</style>
						<fieldset>
							<legend>Le tue sale</legend>
							<?php
							
								$sql = "select * from sale;";

								$result = mysqli_query($connessione, $sql);
								$num_result = mysqli_num_rows($result);

								$leTueSale = '';

								for($i=0; $i < $num_result; $i++)
								{
									$row = mysqli_fetch_array($result);
									$leTueSale .= '<div class="row infoBoxSpecial">' . $row["Nome_sala"] . ' - ' . $row["Numero_posti_prenotabili"] . ' posti</div>';
								}
								$leTueSale .= '';
								echo $leTueSale;
							?>
						</fieldset>
						<hr>
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