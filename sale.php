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

    <link rel="stylesheet" type="text/css" href="css/datatable.css"/>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable();
        });
    </script>
</head>

<body id="body">
<div class="container py-5">
    <div class="card">
        <div class="card-body">
            <?php
            if(isset($_GET['messaggio'])) {
            ?>
            <div class="alert alert-success">
                <strong>Success! </strong> <?php echo $_GET['messaggio']; ?>
            </div>
            <?php
            }
            if(isset($_GET['alert'])) {
                ?>
                <div class="alert alert-warning">
                    <strong>Warning! </strong> <?php echo $_GET['alert']; ?>
                </div>
                <?php
            }
            /*
             * CONTROLLI SULLE PRENOTAZIONI
            else if(isset($_GET['msg1'])) {
                $id = $_GET['msg1'];
                $query = "DELETE FROM sale WHERE id_sala='$id'";

                $result = $connessione->query($query);

                header("Location: sale.php?messaggio=Sala eliminata con successo");
            }*/
                ?>
            <h1 class="card-title text-center">Lista sale <a href="AggiuntaNuovaSala.php" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span></a></h1>
            <br><br>
            <table id="table">
                <thead>
                <tr>
                    <th>Id sala</th>
                    <th>Nome sala</th>
                    <th>Posti prenotabili</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM sale";
                $result = $connessione->query($query);
                $numrows = $result->num_rows;

                if ($numrows) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <?php
                            echo "<td>" . $row['id_sala'] . "</td>";
                            echo "<td>" . $row['Nome_sala'] . "</td>";
                            echo "<td>" . $row['Numero_posti_prenotabili'] . "</td>";
                            ?>
                            <td>
                                <a href="AggiuntaNuovaSala.php?id=<?php echo $row['id_sala'] ?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                            </td>
                            <td>
                                <a href="sale.php?msg1=<?php echo $row['id_sala']; ?>">
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
    </div>
</body>
</html>
