<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
		<style>
		body {
			
		}
		.check { 
			position: absolute; 
			right: 0px; 
			top: 0px; 
			background-color: #BBBBBB; 
			height: 100%; 
			width: 450px; 
			float: left; 
		}
		* { font-family: Arial; }
		.form { width: 100%; height: 100%; }
		input[type=text], input[type=number], input[type=date], select, textarea, input[type=submit], input[type=button] { width: 100%; height: 30px; line-height: 30px; font-size: 18px; margin-bottom: 10px; }
		input[type=number], select, input[type=date], #A, #B { float: left; }
		#B, select { width: 50%; }
		select { width: 70%; }
		#C { margin-right: 10px; width: calc(30% - 10px); }
		input[type=number], input[type=date], #A { margin-right: 10px; width: calc(50% - 10px); }
		textarea { height: 180px; font-size: 15px; line-height: 18px; resize: none; }
		input[type=submit], input[type=button] { height: 40px; border-radius: 20px; }
		.dettagli, .verifica { width: 100%; padding: 0px 10%; }
		.verifica { background-color: #EEEEEE; }
		</style>
	</head>
	<body>
		<div class='check'>
			<form method='POST' class='form'>
				<div class='verifica'>
					<br>
					<fieldset>
						<legend>Verifica disponibilità orario</legend>
						<!-- <input type='date' id='F' name='F'/> -->
						<input type='number' id='C' name='C' placeholder='Numero'/>
						<select name='D' disabled>
							<option value='a'>12.00</option>
							<option value='b'>12.30</option>
							<option value='c'>13.00</option>
						</select>
					</fieldset>
					<br>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Verifica disponibilit&agrave
						</button>
					</div>
					<br>
				</div>
				<div class='dettagli'>
					<br>
					<fieldset>
						<legend>Dettagli</legend>
						<input type='text' id='A' name='A' placeholder='Cognome'/>
						<input type='text' id='B' name='B' placeholder='Telefono'/>
						<textarea name='E' id='E' >Eventuali note</textarea>
					</fieldset>
					<br>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Prenota
						</button>
					</div>
				</div>
			</form>
		
		</div>
	</body>
</html>