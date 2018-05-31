<html>
	<?php

		// Connessione al DB

		$host = "localhost";
		$user = "root";
		$pass = "";
		$dbname = "ristorante";
		$connessione = mysqli_connect($host, $user, $pass);
		$db_selected=mysqli_select_db($connessione, $dbname);
		
		if($_GET != null && isset($_GET["id"]))
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
        
        <style>
            body {
                background-color: white;
            }
        </style>
        
		<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
		
		var conteggi = [ 0, 0, 0, 0, 0, 0];
		
		function aggiungiOrario(a)
		{
			var b = document.getElementById(a).innerHTML;
			var c = a.substring(4);
			document.getElementById(a).innerHTML = b.replace("<br>", 
			'<div class="row" id="Riga' + conteggi[c] + '"><div class="col-md-8"><input type="text" id="Casella' + conteggi[c] + '" name="orario' + a + '[]" class="form-control" placeholder="Orario"><span class="help-block"></span></div><div class="col-xs-4"><button onclick="deleteRow(\'' + conteggi[c] + '\');" class="btn btn-danger center-text" type="button" >&#10006;</button></div></div><br>');
			
			conteggi[c]++;
			// '<input type="text" name="orario' + a + '[]" class="form-control" placeholder="Orario"><span class="help-block"></span><br>');
		}
		function refresh()
		{
			var a = document.getElementById("sel0").value;
			window.location.href = "AggiuntaNuovaFasciaOraria.php?id=" + a;
		}
		function deleteRow(a)
		{
			document.getElementById("Casella" + a).value = "";
			document.getElementById("Riga" + a).style.display = "none";
		}
		function rimozione()
		{
			var a = document.getElementById("sel0");
			var b = a.options[a.selectedIndex].value;
			window.location.href = "../codici/deleteFasciaOraria.php?id=" + b;
		}
		</script>
		
	</head>
	<body style="font-family: Arial;">
		<div class="container">
			<?php
            if(isset($_GET['messaggio'])) {
            ?>
				<br><div class="alert alert-success">
					<strong>Ottimo! </strong> <?php echo $_GET['messaggio']; ?>
				</div>
            <?php
            }
            if(isset($_GET['alert'])) {
            ?>
                <br><div class="alert alert-warning">
                    <strong>Attezione! </strong> <?php echo $_GET['alert']; ?>
                </div>
            <?php
            }
			?>
		</div>
		<h1 class="card-title text-center"><?php if($_GET != null) echo "Modifica fascia oraria"; else echo "Aggiungi nuova fascia oraria";?></h1>
		<div class="container">
			<hr>
			<div class="row">
				<form id="insertFO" method="POST" action="<?php if($_GET != null) echo "../codici/updateFasciaOraria.php"; else echo "../codici/insertFasciaOraria.php"; ?>">
					<div class="col-md-3">
						<fieldset>
					
							<?php
							
							if($_GET == null)
							{
							?>
								<legend>Dettagli nuova fascia</legend>
								<div class="form-group">
									<a data-toggle="tooltip" title="Cerca un nome efficace e intuitivo (Ex. Solo pranzo)">
										<label>Nome identificativo</label>
									</a>
									<label></label>
									<input type="text" name="nomeFascia" id="nomeFascia" class="form-control"
									<?php if(isset($name)) echo "value='" . $name . "'"; ?>
									placeholder="Nome">
									<span class="help-block">Questo nome verrà visualizzato solo nella parte amministrativa.</span>
								</div>
							<?php
							}
							else
							{
								$sql = "select * from gestionefasceorarie order by id_fascia;";

								$result = mysqli_query($connessione, $sql);
								$num_result = mysqli_num_rows($result);

								$select = '
									<legend>Scegli la fascia</legend>
									<div class="form-group">
										<label for="sel0">Seleziona l\'orario</label>
										<select class="form-control" id="sel0" name="giorno0" onchange="refresh();">';

								for($i=0; $i < $num_result; $i++)
								{
									$row = mysqli_fetch_array($result);
									$select .= '<option value="' . $row["id_fascia"] . '">' . $row["nome"] . '</option>';
								}
								$select .= '</select></div>';
								echo $select;
								if(isset($_GET["id"]))
									echo "<script> document.getElementById('sel0').value = " . $_GET["id"] . ";</script>";
								
							}
							?>
							
							<hr>
							<button class="btn btn-primary" onclick="vai();"  style="width: 100%;">
								<h4>
									<?php if($_GET != null) echo "Aggiorna"; else echo "Aggiungi"; ?>
								</h4>
							</button>
							
							<?php 
							if($_GET != null) 
								echo '<a class="btn btn-danger" onclick="rimozione();" role="button" style="width: 100%; margin-top: 10px; ">Elimina</a>';
							?>
						</fieldset>
					</div>
					
					<div class="col-md-9">
						<legend>Selezione orari</legend>
						<div class="row">
							
								<?php
									$fasi = array("Colazione", "Brunch", "Pranzo", "Aperitivo", "Cena", "Serata");
									$num = count($fasi);
									
									for($i=0; $i < $num; $i++)
									{
										if($i % 2 == 0)
											echo '<div class="col-md-1"><br></div>
												<div class="col-md-3">';
										
										echo '<label>' . $fasi[$i] . '</label>
										<div id="Fase' . $i . '" class="row">';
										
										if(isset($orari[$i]))
											for($j = 0; $j < sizeof($orari[$i]); $j++)
												echo '<div class="row" id="Riga' . $i . $orari[$i][$j] . '">
											<div class="col-md-8">
												<input type="text" id="Casella' . $i . $orari[$i][$j] . '" name="orario' . $i . '[]" class="form-control" value="' . $orari[$i][$j] . '" placeholder="Orario">
												<span class="help-block"></span>
											</div>
											<div class="col-xs-4">
												<button onclick="deleteRow(\'' . $i . $orari[$i][$j] . '\');" class="btn btn-danger center-text" type="button" >
													&#10006;
												</button>
											</div>
											</div>
											';
										
										echo '<br>
											<button onclick="aggiungiOrario(\'Fase' . $i . '\');" class="btn btn-primary" type="button" >
												Aggiungi riga
											</button>
										</div><hr>';
										
										if(($i + 1) % 2 == 0)
											echo '</div>';
									}
								
								?>
							
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
		if(document.getElementById("nomeFascia").value != "")
			document.getElementById("insertFO").submit();
		else
			alert("Attribuisci un nome alla fascia oraria!");
	}
	</script>
</html>