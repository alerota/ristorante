
<style>

.btn-fourth {
	background-color: rgb(180, 180, 180);
	color: white;
}
.btn-fourth:hover {
	background-color: rgb(140, 140, 140);
	color: white;
}
.btn { margin-bottom: 10px; }
</style>

<div class="container">
	<div class="pannelloGestionale row">
			<?php
			include 'classi/calendarAdmin.php';
			$calendar = new CalendarAdmin();
			
			echo '<div class="col-md-5">';
			echo "<br>" . $calendar->show() . "</div>";
			
			echo '<div class="col-md-1"><br></div>';
		
			if(!isset($_GET["date"]))
			{
				$today = date("Y-n-j");
				echo '<div class="col-md-6">
					<div class="row">
						<div class="col-xs-12">
							<br>
							<style>
							.btn-group button { width: 19%; margin: 0px 0.5% !important; }
							.btn-group { width: 100%; }
							</style>
							<div class="btn-group">
								<button onclick="" class="btn btn-warning" type="button">
										<h4><div class="glyphicon glyphicon-gift"></div></h4>
								</button>
								<button onclick="window.location.href=\'elenchi/prenotazioni.php?date=' . $today . '\';" class="btn btn-primary" type="button">
										<h4><div class="glyphicon glyphicon-time"></div></h4>
								</button>
								<button onclick="window.location.href=\'elenchi/prenotazioni.php\';" class="btn btn-success" type="button">
										<h4><div class="glyphicon glyphicon-calendar"></div></h4>
								</button>
								<button onclick="window.location.href=\'elenchi/revisionare.php\';" class="btn btn-danger" type="button">
										<h4><div class="glyphicon glyphicon-remove"></div></h4>
								</button>
								<button onclick="window.location.href=\'gestionale.php\';" class="btn btn-fourth" type="button">
										<h4><div class="glyphicon glyphicon-cog"></div></h4>
								</button>
							</div>
						</div>
					</div>
					<div class="row">';
				include "codici/notificheGiornaliere.php";
				echo '</div>
				</div>';
			}
			else
			{
				echo "<div class='col-md-6'>";
				include "forms/check.php";
				echo "</div>";
			}
			?>
		
	</div>
</div>