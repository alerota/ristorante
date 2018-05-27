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
			$sql = "select * from gestionefasceorarie where id_fascia = " . $idImportante . ";";

			$result = mysqli_query($connessione, $sql);
			$num_result = mysqli_num_rows($result);
			
			if($num_result == 1)
			{
				$row = mysqli_fetch_array($result);
				$name = $row["nome"];
				
				$sql = "select * from fasceorarie where id_fascia = " . $idImportante . " order by orario;";
				
				$result = mysqli_query($connessione, $sql);
				$num_result = mysqli_num_rows($result);
				
				$orari = array();
				
				for($i=0; $i < 6; $i++)
					$orari[$i] = array();
				
				for($i=0; $i < $num_result; $i++)
				{
					$row = mysqli_fetch_array($result);
					array_push($orari[$row["fase"]], $row["orario"]);
				}
			}
			else
				echo "<script>alert('Problemi durante il caricamento della fascia, chiedere assistenza...');</script>";
		}

		include '../menu.php';

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
		
		function aggiungiOrario(a)
		{
			var b = document.getElementById(a).innerHTML;
			document.getElementById(a).innerHTML = b.replace("<br>", '<input type="text" name="orario' + a + '[]" class="form-control" placeholder="Orario"><span class="help-block"></span><br>');
		}
		</script>
		
	</head>
	<body style="font-family: Arial;">
    <h1 class="card-title text-center"><?php if($_GET != null) echo "Modifica fascia oraria: ".$name; else echo "Aggiungi nuova fascia oraria";?></h1>
		<div class="container">
			<hr>
			<div class="row">
				<form id="insertFO" action="../codici/insertFasciaOraria.php">
					<div class="col-md-3">
						<fieldset>
							<legend>Dettagli nuova fascia</legend>
							<div class="form-group">
								<a data-toggle="tooltip" title="Cerca un nome efficace e intuitivo (Ex. Solo pranzo)">
									<label>Nome identificativo</label>
								</a>
								<label></label>
								<input type="text" name="nomeFascia" class="form-control"
								<?php if(isset($name)) echo "value='" . $name . "'"; ?>
								placeholder="Nome">
								<span class="help-block">Questo nome verrà visualizzato solo nella parte amministrativa.</span>
							</div>
						</fieldset>
						<hr>
                        <a class="btn btn-primary" onclick="vai();" role="button" style="width: 100%;">Cerca</a>
					</div>
                </form>
                <form method="POST" id="insertFO" action="codici/insertFasciaOraria.php">
					<div class="col-md-9">
						<legend>Selezione orari</legend>
						<div class="row">
							<div class="col-md-4">
								<?php
									$fasi = array("Colazione", "Brunch", "Pranzo", "Aperitivo", "Cena", "Serata");
									$num = count($fasi);
									
									for($i=0; $i < $num / 3; $i++)
									{
										echo '<label>' . $fasi[$i] . '</label>
										<div id="Fase' . $i . '" class="row">';
										
										if(isset($orari[$i]))
											for($j = 0; $j < sizeof($orari[$i]); $j++)
												echo '<input type="text" name="orario' . $i . '[]" class="form-control" value="' . $orari[$i][$j] . '" placeholder="Orario"><span class="help-block"></span>';
										
										echo '<br>
											<button onclick="aggiungiOrario(\'Fase' . $i . '\');" class="btn btn-primary" type="button" >
												Aggiungi riga
											</button>
										</div><hr>';
									}
									
								
								?>
							</div>
							<div class="col-md-4">
								<?php
									
									for($i= $num / 3; $i < $num * 2 / 3; $i++)
									{
										echo '<label>' . $fasi[$i] . '</label>
										<div id="Fase' . $i . '">';
										
										if(isset($orari[$i]))
											for($j = 0; $j < sizeof($orari[$i]); $j++)
												echo '<input type="text" name="orario' . $i . '[]" class="form-control" value="' . $orari[$i][$j] . '" placeholder="Orario"><span class="help-block"></span>';
										
										echo '<br>
											<button onclick="aggiungiOrario(\'Fase' . $i . '\');" class="btn btn-primary" type="button" >
												Aggiungi riga
											</button>
										</div><hr>';
									}
									
								
								?>
							</div>
							<div class="col-md-4">
								<?php
									
									for($i= $num * 2 / 3; $i < $num; $i++)
									{
										echo '<label>' . $fasi[$i] . '</label>
										<div id="Fase' . $i . '">';
										
										if(isset($orari[$i]))
											for($j = 0; $j < sizeof($orari[$i]); $j++)
												echo '<input type="text" name="orario' . $i . '[]" class="form-control" value="' . $orari[$i][$j] . '" placeholder="Orario"><span class="help-block"></span>';
										
										echo '<br>
											<button onclick="aggiungiOrario(\'Fase' . $i . '\');" class="btn btn-primary" type="button" >
												Aggiungi riga
											</button>
										</div><hr>';
									}
									
								
								?>
							</div>
						</div>
					</div>
				</form>
				<hr>
			</div>
			<hr>
		</div>
	</body>

	<script>
	function vai() {
		document.getElementById("insertFO").submit();
	}
	</script>
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>