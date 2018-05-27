
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
						<div class="col-md-6"><br>
							<button onclick="" class="btn btn-warning center-block" type="button" style="width: 100%; ">
									<h4>Prenota festa</h4>
							</button>
							<button onclick="window.location.href=\'elenchi/prenotazioni.php?date=' . $today . '\';" class="btn btn-success center-block" type="button" style="width: 100%; ">
									<h4>Prenotati (oggi)</h4>
							</button>
						</div>
						<div class="col-md-6"><br>
							<button onclick="window.location.href=\'elenchi/prenotazioni.php\';" class="btn btn-success center-block" type="button" style="width: 100%; ">
									<h4>Prenotati</h4>
							</button>
							<button onclick="window.location.href=\'elenchi/revisionare.php\';" class="btn btn-success center-block" type="button" style="width: 100%; ">
									<h4>Prenotati da revisionare</h4>
							</button>
							<button onclick="window.location.href=\'gestionale.php\';" class="btn btn-fourth center-block" type="button" style="width: 100%; ">
									<h4>Gestionale</h4>
							</button>
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