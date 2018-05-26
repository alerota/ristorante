<html>
	<head>
        <link href="style/calendar.css" type="text/css" rel="stylesheet" />
        <link href="vendor\bootstrap\css\bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="vendor\bootstrap\css\bootstrap.css" type="text/css" rel="stylesheet" />
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->

	</head>
	<body style="background-position:center; background-size: cover; ">
		<?php
        include 'menu.php';
		
		if(isset($_COOKIE['login']))
		{
			include "Homepage.php";
		}
		else
		{
			echo '<style>body { background-image: url("images/pikachu.gif"); }</style>';
			
			if(isset($_GET['messaggio']))
				echo '<div class="container"><br><div class="row"><div class="col-xs-12"><div class="alert alert-success">
						<strong>Prenotazione inviata con successo! </strong> ' . $_GET['messaggio'] . '
					</div></div></div></div>';
			else if(isset($_GET['alert']))
				echo '<div class="container"><br><div class="row"><div class="col-xs-12"><div class="alert alert-warning">
						<strong>Errore! </strong> ' . $_GET['alert'] . '
					</div></div></div></div>';
			
			echo '<div class="container-fluid">
			<div class="row">
				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"><br></div>
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<br>';
			include 'calendar.php';
			$calendar = new Calendar();
			echo $calendar->show();
			echo '</div>
				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"><br></div>
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">';
					if(isset($_GET["date"]))
						include 'check.php';
				echo '</div>
			</div>';
		}
		?>
	</body>
</html>    
