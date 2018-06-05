<?php
if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://localhost/ristorante/index.php";</script>';
    exit();
}
else {
    ?>

    <div class="container">
        <div class="pannelloGestionale row">
            <?php
            include 'classi/calendarAdmin.php';
            $calendar = new CalendarAdmin();

            echo '<div class="col-md-5">';
            echo "<br>" . $calendar->show() . "</div>";

            echo '<div class="col-md-1"><br></div>';

            if (!isset($_GET["date"])) {
                $today = date("Y-n-j");
                echo '<div class="col-md-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <br>
                                <style>
                                .btn-group .primaRiga { width: 19%; margin: 0px 0.5% !important; }
                                .btn-group .secondaRiga { width: 49%; margin: 0px 0.5% !important; }
                                .btn-group { width: 100%; }
                                .searchByDate { width: 100%; }
                                </style>
                                <div class="btn-group">
                                    <button data-toggle="modal" data-target="#prenotaFesta" class="btn btn-warning primaRiga" type="button">
                                            <h4><div class="glyphicon glyphicon-gift"></div></h4>
                                            <h6>Prenota Festa</h6>
                                    </button>
                                    <button onclick="window.location.href=\'elenchi/prenotazioni.php?date=' . $today . '\';" class="btn btn-primary primaRiga" type="button">
                                            <h4><div class="glyphicon glyphicon-time"></div></h4>
                                            <h6>Prenotati Oggi</h6>
                                    </button>
                                    <button onclick="window.location.href=\'elenchi/prenotazioni.php\';" class="btn btn-success primaRiga" type="button">
                                            <h4><div class="glyphicon glyphicon-calendar"></div></h4>
                                            <h6>Prenotazioni</h6>
                                    </button>
                                    <button onclick="window.location.href=\'elenchi/revisionare.php\';" class="btn btn-danger primaRiga" type="button">
                                            <h4><div class="glyphicon glyphicon-remove"></div></h4>
                                            <h6>Da Revisionare</h6>
                                    </button>
                                    <button onclick="window.location.href=\'Impostazioni.php\';" class="btn btn-fourth primaRiga" type="button">
                                            <h4><div class="glyphicon glyphicon-cog"></div></h4>
                                            <h6>Impostazioni</h6>
                                    </button>
                                </div>
                                <hr><h3 style="text-align: center;">Ricerca nel periodo</h3>
                                <form id="searchByDate" action="elenchi/prenotazioni.php">
                                    <div class="row">
                                        <div class="col-md-4" style="padding-top: 8px; height: 45px; ">
                                            <input type="date" class="searchByDate" name="strt" id="inizio" >
                                        </div>
                                        <div class="col-md-4" style="padding-top: 8px; height: 45px; ">
                                            <input type="date" class="searchByDate" name="nd" id="fine">
                                        </div>
                                        <div class="col-md-4 text-center" style="padding-top: 4px; height: 45px; ">
                                            <a onclick="document.getElementById(\'searchByDate\').submit();" class="btn btn-success secondaRiga" type="button" style="width: 100%; ">
                                                Ricerca
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">';
                include "codici/notificheGiornaliere.php";
                echo '</div>
                    </div>';
            } else {
                echo "<div class='col-md-6'>";
                include "forms/check.php";
                echo "</div>";
            }
            ?>

        </div>
    </div>
    <?php
}
?>