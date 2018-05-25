<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ristorante";

$connessione = new mysqli($host, $user, $pass, $dbname);

if ($connessione->connect_errno) {
    echo "Errore in connessione al DBMS: " . $connessione->error;
}
include 'menu.php';
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script src="js/confirmation.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/datatable.css"/>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable();
        });
        $(document).ready(function () {
            $('#table1').DataTable();
        });
    </script>
    <style type="text/css">
        #warning-message { display: none; }
        @media only screen and (orientation:portrait){
            #wrapper { display:none; }
            #warning-message { display:block; }
        }
        @media only screen and (orientation:landscape){
            #warning-message { display:none; }
        }
    </style>

</head>

<body id="body">
<div class="container py-5">
    <div class="card" id="wrapper">
        <div class="card-body">
            <?php
            if(isset($_GET['messaggio'])) {
                ?>
                <div class="alert alert-warning">
                    <strong>Warning! </strong> <?php echo $_GET['messaggio']; ?>
                </div>
                <?php
            }
            /* cancellazione non ancora implementata
            if(isset($_GET['msg1'])) {
                $id = $_GET['msg1'];
                $query = "DELETE FROM prenotazioni WHERE id_prenotazione='$id'";

                $result = $connessione->query($query);

                echo "<script> window.location.href= 'prenotazioni.php?messaggio=Cliente rimasto nella lista clienti!';</script>";
            }
            else {*/
            ?>

            <div class="row">
                <div class="col-sm-6">

                    <h1 class="card-title text-center">Lista stagioni <a href="AggiuntaNuovaStagione.php" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span></a></h1>
                    <br><br>
                    <table id="table">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Giorno inizio</th>
                            <th>Giorno fine</th>
                            <th>Priorità</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $query = "SELECT * FROM stagioni WHERE giorno_inizio <> giorno_fine ORDER BY priorita DESC";

                        $result = $connessione->query($query);
                        $numrows = $result->num_rows;

                        if ($numrows) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <?php
                                    echo "<td>" . $row['nome_stagione'] . "</td>";

                                    if(strcmp(substr($row['giorno_inizio'], 0, 1), "x") == 0) //se l'anno è x
                                        $i = date("Y") . substr($row['giorno_inizio'], 1); //sostituisco x con l'anno corrente
                                    else
                                        $i = $row['giorno_inizio'];

                                    $inizio = new DateTime($i);
                                    echo "<td>" . $inizio->format('d-m-Y') . "</td>";

                                    if(strcmp(substr($row['giorno_fine'], 0, 1), "x") == 0) //se l'anno è x
                                        $f = date("Y") . substr($row['giorno_fine'], 1); //sostituisco x con l'anno corrente
                                    else
                                        $f = $row['giorno_fine'];

                                    $fine = new DateTime($f);
                                    echo "<td>" . $fine->format('d-m-Y') . "</td>";

                                    echo "<td>" . $row['priorita'] . "</td>";
                                    ?>
                                    <td>

                                        <a href="aggiuntaNuovaStagione.php?id=<?php echo $row['id_stagione'] ?>">
                                            <span class="glyphicon glyphicon-expand"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick="document.getElementById('idSupporto').value=<?php echo $row['id_prenotazione']; ?>;" class="confirm">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>


                <div class="col-sm-6">
                    <h1 class="card-title text-center">Lista giorni speciali <a href="AggiuntaGiornoSpeciale.php" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span></a></h1>
                    <br><br>
                    <table id="table1">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Giorno</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $query = "SELECT * FROM stagioni WHERE giorno_inizio = giorno_fine ORDER BY priorita DESC";

                        $result = $connessione->query($query);
                        $numrows = $result->num_rows;

                        if ($numrows) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <?php
                                    echo "<td>" . $row['nome_stagione'] . "</td>";

                                    if(strcmp(substr($row['giorno_inizio'], 0, 1), "x") == 0) //se l'anno è x
                                        $i = date("Y") . substr($row['giorno_inizio'], 1); //sostituisco x con l'anno corrente
                                    else
                                        $i = $row['giorno_inizio'];

                                    $inizio = new DateTime($i);
                                    echo "<td>" . $inizio->format('d-m-Y') . "</td>";
                                    ?>
                                    <td>

                                        <a href="aggiuntaGiornoSpeciale.php?id=<?php echo $row['id_stagione'] ?>">
                                            <span class="glyphicon glyphicon-expand"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick="document.getElementById('idSupporto').value=<?php echo $row['id_prenotazione']; ?>;" class="confirm">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    //}
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <div id="warning-message">
        <br>
        <div class="alert alert-warning">
            <h3><strong>Attenzione!</strong> Questa pagina è visualizzabile solo se orienti il cellulare in orizzontale</h3>
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
                    window.location.href = "prenotazioni.php?msg1=" + a;
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
