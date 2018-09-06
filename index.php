<?php
    include 'menu.php';
		
	if(isset($_COOKIE['login']))
	{
		include "Homepage.php";
	}
	else
	{
		echo '<style> body { background-image: url("images/pikachu.jpg"); background-position:center; background-size: cover; background-attachment: fixed; } </style>';
		
		if(isset($_GET['messaggio']))
			echo '<div class="container"><br><div class="row"><div class="col-xs-12"><div class="alert alert-success">
					<strong>Ottimo! </strong> ' . $_GET['messaggio'] . '
				</div></div></div></div>';
		else if(isset($_GET['alert']))
			echo '<div class="container"><br><div class="row"><div class="col-xs-12"><div class="alert alert-warning">
					<strong>Attenzione! </strong> ' . $_GET['alert'] . '
				</div></div></div></div>';
		
		echo '<div class="container-fluid">
		<div class="row">
			<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"><br></div>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="opacity:0.9;">
				<br>';
		include 'classi/calendar.php';
		$calendar = new Calendar();
		echo $calendar->show();
		echo '</div>
			<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"><br></div>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="height: calc(100% - 52px) !important;">';
		if(isset($_GET["date"]))
			include 'forms/check.php';
		echo '</div>
		</div>';
	}
	?>
	</body>
</html>    
