<html>
	<head>
        <link href="style/calendar.css" type="text/css" rel="stylesheet" />
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->

	</head>
	<body>
		<?php
        include 'menu.php';
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"><br></div>
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<?php
					include 'calendar.php';
					$calendar = new Calendar();
					echo $calendar->show();
					?>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<?php
					if(isset($_GET["date"]))
						include 'check.php';
					?>
				</div>
			</div>
	</body>
</html>    
