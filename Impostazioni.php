<?php
if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://prenotazioni.ristorante-almolo13.com/index.php";</script>';
    exit();
}
else {
    ?>

    <style>
        .btn {
            width: 100%;
        }
		.btn-group { width: 100%; }
		
		.second .btn {
			width: 49%;
			margin-right: 0.5% !important;
			margin-left: 0.5% !important;
		}
		
		.first .btn {
			width: 32.33%; 
			margin-right: 0.5% !important;
			margin-left: 0.5% !important;
		}
    </style>

    <?php
    include 'menu.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <hr>
                <?php
                if (isset($_GET['messaggio']))
                    echo '<div class="container">
						<br>
						<div class="row">
							<div class="col-xs-12">
								<div class="alert alert-success">
									<a href="' . $_GET["messaggio"] . '" download><strong>Ottimo! </strong> Eccoti il link</a>
								</div>
							</div>
						</div>
					</div>';
                ?>
				
				<h3>Storico</h3>
				<div class="btn-group first">
					<button onclick="window.location.href='codici/creaCsv.php?a=m&t=file';" class="btn btn-primary" type="button">
						<h4>Salva</h4>
					</button>

					<button onclick="window.location.href='codici/creaCsv.php?a=m&t=mail';" class="btn btn-primary" type="button">
						<h4>Invia</h4>
					</button>

					<button onclick="window.location.href='codici/creaCsv.php?a=c&t=file';" class="btn btn-danger" type="button">
						<h4>Svuota</h4> <!-- questo cancella oltre che salvare -->
					</button>
				</div>
				<hr>
				<h3>Gestione</h3>
				<div class="btn-group second">
					<button onclick="window.location.href='http://prenotazioni.ristorante-almolo13.com/elenchi/sale.php';" class="btn btn-success" type="button">
						<h4>Gestisci Sale</h4>
					</button>

					<button onclick="window.location.href='http://prenotazioni.ristorante-almolo13.com/forms/AggiuntaNuovaFasciaOraria.php?id=-1';" class="btn btn-success" type="button">
						<h4>Gestisci Fasce</h4>
					</button>
				</div>
				
				<div class="btn-group second">
					<button onclick="window.location.href='http://prenotazioni.ristorante-almolo13.com/elenchi/stagioni_giorniSpeciali.php';" class="btn btn-success" type="button">
						<h4>Gestisci Stagioni</h4>
					</button>

					<button onclick="window.location.href='http://prenotazioni.ristorante-almolo13.com/elenchi/utenti.php';" class="btn btn-success" type="button">
						<h4>Gestisci Utenti</h4>
					</button>
				</div>

				<hr>
				<h3>Configurazione</h3>
                <button onclick="alert('Javascript funziona alla perfezione!');" class="btn btn-warning" type="button">
                    <h4>Test Javascript</h4>
                </button>


            </div>
			<div class="col-md-6">
				<hr>
				<br><br><br><br><br><br><br><br>
				<?php include "codici/notificheGiornaliere.php"; ?>
			</div>
        </div>
    </div>
    <?php
}
?>