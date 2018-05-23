
<style>

.btn-fourth {
	background-color: rgb(180, 180, 180);
	color: white;
}
.btn-fourth:hover {
	background-color: rgb(140, 140, 140);
	color: white;
}
</style>

<div class="container">
	<hr>
	<div class="pannelloGestionale row">
		<div class="col-md-1"><br></div>
		<div class="col-md-7">
			<?php
			include 'calendarAdmin.php';
			$calendar = new CalendarAdmin();
			echo $calendar->show();
			?>
		</div>
		<div class="col-md-1"><br></div>
		
		<div class="col-md-3">
			<button onclick="window.location.href='index.php';" class="btn btn-primary center-block" type="button" style="width: 100%; ">
					<h4>Nuova prenotazione</h4>
			</button>
			<br>
			<button onclick="window.location.href='index.php';" class="btn btn-danger center-block" type="button" style="width: 100%; ">
					<h4>Prenotazione sicura</h4>
			</button>
			<br>
			<button onclick="" class="btn btn-warning center-block" type="button" style="width: 100%; ">
					<h4>Prenota festa</h4>
			</button>
			<br>
			<button onclick="window.location.href='prenotazioni.php';" class="btn btn-success center-block" type="button" style="width: 100%; ">
					<h4>Prenotati (oggi)</h4>
			</button>
			<br>
			<button onclick="window.location.href='prenotazioni.php';" class="btn btn-success center-block" type="button" style="width: 100%; ">
					<h4>Prenotati</h4>
			</button>
			<br>
			<button onclick="" class="btn btn-success center-block" type="button" style="width: 100%; ">
					<h4>Prenotati da revisionare</h4>
			</button>
			<br>
			<button onclick="window.location.href='gestionale.php';" class="btn btn-fourth center-block" type="button" style="width: 100%; ">
					<h4>Gestionale</h4>
			</button>
		</div>
	</div>
	<hr>
</div>