<!DOCTYPE html>
<html lang="en">
	<?php
	if($_POST != null)
	{
		$host = "localhost";
		$user = "root";
		$pass = "";
		$dbname = "ristorante";

		$connessione = new mysqli($host, $user, $pass, $dbname);

		if ($connessione->connect_errno) {
			echo "Errore in connessione al DBMS: " . $connessione->error;
		}

		$username = ($_POST['username']);
		$password = md5($_POST['pass']);
		$result = $connessione->query("SELECT * FROM utenti WHERE username='$username' AND password='$password'");

		if ($result->num_rows == 1) {
			setcookie('login', $username, time()+2592000);
			header("Location: index.php");
		}
		else
			header("Location: index.php");
	}
	else
		$username = "";
	?>
	<head>
		<title>Ristorante Al molo 13</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://localhost/ristorante/vendor\bootstrap\css\bootstrap.min.css">
		<link href="http://localhost/ristorante/style/calendar.css" type="text/css" rel="stylesheet" />
		<link href="http://localhost/ristorante/css\stiliLogin.css" rel="stylesheet">
		
		
		<script src="http://localhost/ristorante/vendor/jquery/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="http://localhost/ristorante/vendor/dataTable/css/jquery.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="http://localhost/ristorante/vendor/dataTable/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="http://localhost/ristorante/css/datatable.css"/>
		
        <link rel="stylesheet" type="text/css" href="http://localhost/ristorante/vendor/confirm/css/jquery-confirm.min.css">
        <script type="text/javascript" charset="utf8" src="http://localhost/ristorante/vendor/confirm/js/jquery-confirm.min.js"></script>

		
		<script src="http://localhost/ristorante/vendor\bootstrap\js\bootstrap.min.js"></script>
		<script src="http://localhost/ristorante/js\codiciLogin.js"></script>
		<style>
		 
			.dropdown-menu > li.kopie > a {
				padding-left:5px;
			}
			 
			.dropdown-submenu {
				position:relative;
			}
			.dropdown-submenu>.dropdown-menu {
			   top:0;left:100%;
			   margin-top:-6px;margin-left:-1px;
			   -webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;
			 }
			  
			.dropdown-submenu > a:after {
			  border-color: transparent transparent transparent #333;
			  border-style: solid;
			  border-width: 5px 0 5px 5px;
			  content: " ";
			  display: block;
			  float: right;  
			  height: 0;     
			  margin-right: -10px;
			  margin-top: 5px;
			  width: 0;
			}
			 
			.dropdown-submenu:hover>a:after {
				border-left-color:#555;
			 }
			  
			.dropdown-menu li {
				padding-top: 2.5px;
				padding-bottom: 2.5px;
			 }
			
			@media (max-width: 767px) {
			  .navbar-nav  {
				 display: inline;
			  }
			  .navbar-default .navbar-brand {
				display: inline;
			  }
			  .navbar-default .navbar-toggle .icon-bar {
				background-color: #fff;
			  }
			  .navbar-default .navbar-nav .dropdown-menu > li > a {
				color: red;
				background-color: #ccc;
				border-radius: 4px;
				margin-top: 2px;   
			  }
			   .navbar-default .navbar-nav .open .dropdown-menu > li > a {
				 color: #333;
			   }
			   .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
			   .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
				 background-color: #ccc;
			   }

			   .navbar-nav .open .dropdown-menu {
				 border-bottom: 1px solid white; 
				 border-radius: 0;
			   }
			  .dropdown-menu {
				  padding-left: 10px;
			  }
			  .dropdown-menu .dropdown-menu {
				  padding-left: 20px;
			   }
			   .dropdown-menu .dropdown-menu .dropdown-menu {
				  padding-left: 30px;
			   }
			   li.dropdown.open {
				border: 0px solid red;
			   }
			}
			 
			@media (min-width: 768px) {
			  ul.nav li:hover > ul.dropdown-menu {
				display: block;
			  }
			  #navbar {
				text-align: center;
			  }
			}  

		</style>
	</head>
	<body>

		<nav class="navbar navbar-inverse" style="border-radius: 0px; margin-bottom: 0px !important;">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="http://localhost/ristorante/index.php">Al molo 13</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						
						<?php
						if(isset($_COOKIE['login']))
						{
							$today = date("Y-n-j");
							echo '
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Sale<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="http://localhost/ristorante/forms/AggiuntaNuovaSala.php">Aggiungi Sala</a></li>
									<li><a href="http://localhost/ristorante/elenchi/sale.php">Elenca Sale</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Prenotazioni<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="http://localhost/ristorante/index.php">Aggiungi prenotazione</a></li>
									<li><a class="nav-link" href="#" data-toggle="modal" data-target="#prenotaFesta">Aggiungi festa</a></li>
									<li><a href="http://localhost/ristorante/elenchi/prenotazioni.php">Elenca prenotati</a></li>
									<li><a href="http://localhost/ristorante/elenchi/revisionare.php">Da revisionare</a></li>
									<li><a href="http://localhost/ristorante/elenchi/clienti.php">Storico</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Stagioni<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="http://localhost/ristorante/forms/AggiuntaNuovaStagione.php">Aggiungi stagione</a></li>
									<li><a href="http://localhost/ristorante/forms/AggiuntaGiornoSpeciale.php">Aggiungi giorno speciale</a></li>
									<li><a href="http://localhost/ristorante/elenchi/stagioni_giorniSpeciali.php">Elenca stagioni</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Fasce<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="http://localhost/ristorante/forms/AggiuntaNuovaFasciaOraria.php">Aggiungi fascia</a></li>
									<li><a href="http://localhost/ristorante/forms/AggiuntaNuovaFasciaOraria.php?id=-1">Modifica fasce</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Utenti<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="http://localhost/ristorante/forms/AggiuntaNuovoUtente.php">Aggiungi utente</a></li>
									<li><a href="http://localhost/ristorante/elenchi/utenti.php">Elenca utenti</a></li>
								</ul>
							</li>';
							
						}
						?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<?php
							if(isset($_COOKIE['login']))
								echo '<a class="nav-link" href="http://localhost/ristorante/logout.php"><span class="glyphicon glyphicon-user"></span> Bentornato ' . $_COOKIE['login'] . ', Logout</a>';
							else
								echo '<a class="nav-link" href="#" data-toggle="modal" data-target="#login-modal"><span class="glyphicon glyphicon-log-in"></span> Login</a>';
							?>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" align="center">
						<img class="img-circle" id="img_logo" src="http://localhost/ristorante/images\logo.png">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
					</div>
					
					<div id="div-forms">
						<form id="login-form" method="POST">
							<div class="modal-body">
								<div id="div-login-msg">
									<div id="icon-login-msg" class="glyphicon glyphicon-menu-right"></div>
									<span id="text-login-msg">Inserire nome utente e password.</span>
								</div>
								<input id="login_username" class="form-control" type="text" name="username" placeholder="Nome utente" required>
								<input id="login_password" class="form-control" type="password" name="pass" placeholder="Password" required>
								
							</div>
							<div class="modal-footer">
								<div>
									<button type="submit" onclick="document.getElementById('login-form').submit();" class="btn btn-primary btn-lg btn-block">Login</button>
								</div>
								<div>
									<br><p class="btn btn-link">P&amp;G Management</p>
								</div>
							</div>
						</form>
						
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="prenotaFesta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; ">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" align="center">
						<img id="img_logo" src="http://localhost/ristorante/images\champagne.png">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
					</div>
					
					<div id="div-forms">
						<form id="formPrenotaFesta" method="POST" action="codici/insert/insertFesta.php">
							<div class="modal-body">
								<div id="div-formPrenotaFesta-msg">
									<div id="icon-formPrenotaFesta-msg" class="glyphicon glyphicon-menu-right"></div>
									<span id="text-formPrenotaFesta-msg">Scegliere un nome e una data.</span>
								</div>
								<input id="nomeFormPrenotaFesta" class="form-control" type="text" name="nome" placeholder="Nome" required>
								<input id="dataFormPrenotaFesta" class="form-control" type="date" name="data" placeholder="Password" required>
								
							</div>
							<div class="modal-footer">
								<div>
									<button type="submit" onclick="document.getElementById('formPrenotaFesta').submit();" class="btn btn-primary btn-lg btn-block">Prenota</button>
								</div>
								<div>
									<br><p class="btn btn-link">Il locale sarà riservato tutto il giorno.</p>
								</div>
							</div>
						</form>
						
					</div>
					
				</div>
			</div>
		</div>
	</body>
</html>