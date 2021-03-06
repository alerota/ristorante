<?php

if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://prenotazioni.ristorante-almolo13.com/index.php";</script>';
    exit();
}
else {

    $host = "localhost";
    $user = "ristoran_pren";
    $pass = "szc[yPA-hIhB";
    $dbname = "ristoran_prenotazioni";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }
    include '../menu.php';
    ?>
    <html>
    <head>
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#table').DataTable();
            });
            $(document).ready(function () {
                $('#table1').DataTable();
            });
        </script>
        <style type="text/css">
            #warning-message {
                display: none;
            }

            @media only screen and (orientation: portrait) {
                #wrapper {
                    display: none;
                }

                #warning-message {
                    display: block;
                }
            }

            @media only screen and (orientation: landscape) {
                #warning-message {
                    display: none;
                }
            }
        </style>

    </head>

    <body id="body">
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="wrapper">
                <br>
                <?php
                if (isset($_GET['messaggio'])) {
                    ?>
                    <div class="alert alert-success">
                        <strong>Ottimo! </strong> <?php echo $_GET['messaggio']; ?>
                    </div>
                    <?php
                }
                if (isset($_GET['alert'])) {
                    ?>
                    <div class="alert alert-warning">
                        <strong>Attenzione! </strong> <?php echo $_GET['alert']; ?>
                    </div>
                    <?php
                }
                ?>
                <h1 class="text-center">Lista stagioni <a href="../forms/AggiuntaNuovaStagione.php"
                                                          class="btn btn-primary btn-sm"><span
                                class="glyphicon glyphicon-plus"></span></a></h1>
                <br>
                <table id="table">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Giorno inizio</th>
                        <th>Giorno fine</th>
                        <th>Priorità</th>
                        <th>Edit</th>
                        <th>Canc</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $query = "SELECT * FROM stagioni WHERE giorno_inizio <> giorno_fine ORDER BY priorita DESC";

                    $result = $connessione->query($query);
                    $numrows = $result->num_rows;

                    if ($numrows) {
                        $nascondi1 = false;
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <?php
                                echo "<td>" . $row['nome_stagione'] . "</td>";

                                if (strcmp(substr($row['giorno_inizio'], 0, 1), "x") == 0) //se l'anno è x
                                    $i = date("Y") . substr($row['giorno_inizio'], 1); //sostituisco x con l'anno corrente
                                else
                                    $i = $row['giorno_inizio'];

                                $inizio = new DateTime($i);
                                echo "<td>" . $inizio->format('d-m-Y') . "</td>";

                                if (strcmp(substr($row['giorno_fine'], 0, 1), "x") == 0) //se l'anno è x
                                    $f = date("Y") . substr($row['giorno_fine'], 1); //sostituisco x con l'anno corrente
                                else
                                    $f = $row['giorno_fine'];

                                $fine = new DateTime($f);
                                echo "<td>" . $fine->format('d-m-Y') . "</td>";

                                echo "<td>" . $row['priorita'] . "</td>";
                                ?>
                                <td>

                                    <a href="../forms/AggiuntaNuovaStagione.php?id=<?php echo $row['id_stagione'] ?>">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a onclick="document.getElementById('idSupporto').value=<?php echo $row['id_stagione']; ?>;"
                                       class="confirm">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else
                        $nascondi1 = true;
                    ?>
                    </tbody>
                </table>
                <?php
                if ($nascondi1) {
                    echo "<script> document.getElementById('table').style.display = 'none'; </script>";
                    echo "<p style='text-align: center;'>Non sono presenti records.</p>";
                }
                ?>
                <h1 class="card-title text-center">Lista giorni speciali <a href="../forms/AggiuntaGiornoSpeciale.php"
                                                                            class="btn btn-primary btn-sm"><span
                                class="glyphicon glyphicon-plus"></span></a></h1>
                <br>
                <table id="table1">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Giorno</th>
                        <th>Edit</th>
                        <th>Canc</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $query = "SELECT * FROM stagioni WHERE giorno_inizio = giorno_fine ORDER BY priorita DESC";

                    $result = $connessione->query($query);
                    $numrows = $result->num_rows;

                    if ($numrows) {
                        $nascondi2 = false;
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <?php
                                echo "<td>" . $row['nome_stagione'] . "</td>";

                                if (strcmp(substr($row['giorno_inizio'], 0, 1), "x") == 0) //se l'anno è x
                                    $i = date("Y") . substr($row['giorno_inizio'], 1); //sostituisco x con l'anno corrente
                                else
                                    $i = $row['giorno_inizio'];

                                $inizio = new DateTime($i);
                                echo "<td>" . $inizio->format('d-m-Y') . "</td>";
                                ?>
                                <td>

                                    <a href="../forms/AggiuntaGiornoSpeciale.php?id=<?php echo $row['id_stagione'] ?>">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a onclick="document.getElementById('idSupporto').value=<?php echo $row['id_stagione']; ?>;"
                                       class="confirm">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else
                        $nascondi2 = true;
                    ?>
                    </tbody>
                </table>
                <input type="hidden" value="" id="idSupporto"/>
                <?php
                if ($nascondi2) {
                    echo "<script> document.getElementById('table1').style.display = 'none'; </script>";
                    echo "<p style='text-align: center;'>Non sono presenti records.</p>";
                }
                ?>
                <?php
                //}
                ?>
            </div>

            <div id="warning-message">
                <br>
                <div class="alert alert-warning">
                    <h3><strong>Attenzione!</strong> Questa pagina è visualizzabile solo se orienti il cellulare in
                        orizzontale</h3>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <script type="text/javascript">
        $(".confirm").confirm({
            content: "",
            title: "Sei sicuro di voler cancellare?",
            buttons: {
                confirm: {
                    action: function () {
                        var a = document.getElementById("idSupporto").value;
                        window.location.href = "../codici/delete/deleteStagioneGiornoSpeciale.php?id=" + a;
                    },
                    text: 'Si',
                    btnClass: 'btn-danger',
                },
                cancel: {
                    action: function () {
                    },
                    text: 'Annulla',
                    btnClass: 'btn-default',
                }
            }
        });
    </script>
    <?php
}
?>