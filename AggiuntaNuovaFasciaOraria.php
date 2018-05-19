<html>
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
		
		function aggiungiOrario(a)
		{
			var b = document.getElementById(a).innerHTML;
			document.getElementById(a).innerHTML = b.replace("<br>", '<input type="text" name="orario' + a + '[]" class="form-control" placeholder="Orario"><span class="help-block"></span><br>');
		}
		</script>
		
	</head>
	<body style="font-family: Arial;">
		
		<div class="container">
			<hr>
			<div class="row">
				<form method="POST" id="insertFO" action="codici/insertFasciaOraria.php">
					<div class="col-md-3">
						<fieldset>
							<legend>Dettagli nuova fascia</legend>
							<div class="form-group">
								<a data-toggle="tooltip" title="Cerca un nome efficace e intuitivo (Ex. Solo pranzo)">
									<label>Nome identificativo</label>
								</a>
								<label></label>
								<input type="text" name="nomeFascia" class="form-control" placeholder="Nome">
								<span class="help-block">Questo nome verrà visualizzato solo nella parte amministrativa.</span>
							</div>
						</fieldset>
						<hr>
						<button onclick="vai();" class="btn btn-danger center-block" type="button" style="width: 100%; ">Aggiungi fascia oraria</button>
					</div>
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
										<div id="Fase' . $i . '" class="row"><br>
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
										<div id="Fase' . $i . '"><br>
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
										<div id="Fase' . $i . '"><br>
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