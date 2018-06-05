<?php
if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://localhost/ristorante/index.php";</script>';
    exit();
}
else {
    ?>

    <style>
        .btn-info {
            width: 100%;
            margin-top: 10px;
        }
    </style>

    <?php
    include 'menu.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
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
                <button onclick="window.location.href='codici/creaCsv.php?a=m&t=file';" class="btn btn-info"
                        type="button">
                    <h4>Salva Csv</h4>
                </button>

                <button onclick="window.location.href='codici/creaCsv.php?a=m&t=mail';" class="btn btn-info"
                        type="button">
                    <h4>Invia Csv</h4>
                </button>

                <button onclick="window.location.href='codici/creaCsv.php?a=c&t=file';" class="btn btn-info"
                        type="button">
                    <h4>Esporta Csv</h4> <!-- questo cancella oltre che salvare -->
                </button>


            </div>
        </div>
    </div>
    <?php
}
?>